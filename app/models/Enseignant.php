<?php


class Enseignant{


    private $db;
    private $id_enseignant;
    private $nom_enseignant;
    private $prenom_enseignant;
    private $email_enseignant;

    private $id_fonction;
    private $date_grade;
    private $date_fonction;

    private $id_specialite;

    private $id_grade;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Getters
    public function getIdEnseignant() { return $this->id_enseignant; }
    public function getNomEnseignant() { return $this->nom_enseignant; }
    public function getPrenomEnseignant() { return $this->prenom_enseignant; }
    public function getEmailEnseignant() { return $this->email_enseignant; }

    public function getIdFonction() { return $this->id_fonction; }
    public function getDateGrade() { return $this->date_grade; }
    public function getDateFonction() { return $this->date_fonction; }

    public function getIdSpecialite() { return $this->id_specialite; }

    public function getIdGrade() { return $this->id_grade; }

    // Setters
    public function setIdEnseignant($id) { $this->id_enseignant = $id; }
    public function setNomEnseignant($nom) { $this->nom_enseignant = $nom; }
    public function setPrenomEnseignant($prenom) { $this->prenom_enseignant = $prenom; }
    public function setEmailEnseignant($email) { $this->email_enseignant = $email; }
    public function setIdGrade($id_grade) { $this->id_grade = $id_grade; }

    public function setIdFonction($id_fonction) { $this->id_fonction = $id_fonction; }
    public function setDateGrade($date_grade) { $this->date_grade = $date_grade; }
    public function setDateFonction($date_fonction) { $this->date_fonction = $date_fonction; }

    public function setIdSpecialite($id_specialite) { $this->id_specialite = $id_specialite; }

    // Méthodes CRUD
    public function getAllEnseignants() {
        $query = "SELECT e.*, f.lib_fonction,f.id_fonction, g.lib_grade, g.id_grade, s.lib_specialite,
                        a.date_grade, o.date_occupation
                 FROM enseignants e 
                 LEFT JOIN avoir a ON e.id_enseignant = a.id_enseignant
                 LEFT JOIN grade g ON a.id_grade = g.id_grade
                 LEFT JOIN occuper o ON e.id_enseignant = o.id_enseignant
                 LEFT JOIN fonction f ON o.id_fonction = f.id_fonction
                 LEFT JOIN specialite s ON e.id_specialite = s.id_specialite 
                 ORDER BY e.nom_enseignant, e.prenom_enseignant";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEnseignantById($id) {
        $query = "SELECT e.*, f.lib_fonction,f.id_fonction, g.lib_grade, g.id_grade, s.lib_specialite,
                        a.date_grade, o.date_occupation
                 FROM enseignants e 
                 LEFT JOIN avoir a ON e.id_enseignant = a.id_enseignant
                 LEFT JOIN grade g ON a.id_grade = g.id_grade
                 LEFT JOIN occuper o ON e.id_enseignant = o.id_enseignant
                 LEFT JOIN fonction f ON o.id_fonction = f.id_fonction
                 LEFT JOIN specialite s ON e.id_specialite = s.id_specialite 
                 WHERE e.id_enseignant = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ajouterEnseignant($nom, $prenom, $email, $id_grade, $id_specialite, $id_fonction, $date_grade, $date_fonction) {
        try {
            $this->db->beginTransaction();
            

            // 1. Insérer dans la table enseignants
            $query = "INSERT INTO enseignants (nom_enseignant, prenom_enseignant, mail_enseignant, id_specialite) 
                     VALUES (:nom, :prenom, :email, :id_specialite)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_specialite', $id_specialite);
            $stmt->execute();

            // Récupérer l'ID du dernier enseignant inséré
            $id_enseignant = $this->db->lastInsertId();

            // 2. Insérer dans la table avoir (liaison enseignant-grade)
            $query = "INSERT INTO avoir ( id_grade,id_enseignant, date_grade) 
                     VALUES (:id_grade,:id_enseignant, :date_grade)";
            $stmt = $this->db->prepare($query);
             $stmt->bindParam(':id_grade', $id_grade);
            $stmt->bindParam(':id_enseignant', $id_enseignant);
            $stmt->bindParam(':date_grade', $date_grade);
            $stmt->execute();

            // 3. Insérer dans la table occuper (liaison enseignant-fonction)
            $query = "INSERT INTO occuper (id_fonction,id_enseignant,date_occupation) 
                     VALUES (:id_fonction,:id_enseignant,:date_fonction)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_fonction', $id_fonction);
            $stmt->bindParam(':id_enseignant', $id_enseignant);
            $stmt->bindParam(':date_fonction', $date_fonction);
            $stmt->execute();

            // Valider la transaction
            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            // En cas d'erreur, annuler la transaction
            $this->db->rollBack();
            error_log("Erreur lors de l'ajout de l'enseignant: " . $e->getMessage());
            return false;
        }
    }

    public function modifierEnseignant($id, $nom, $prenom, $email, $id_grade, $id_specialite, $id_fonction, $date_grade, $date_fonction) {
        try {
            $this->db->beginTransaction();

            // 1. Mettre à jour la table enseignants
            $query = "UPDATE enseignants 
                     SET nom_enseignant = :nom, 
                         prenom_enseignant = :prenom, 
                         mail_enseignant = :email,
                         id_specialite = :id_specialite
                     WHERE id_enseignant = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_specialite', $id_specialite);
            $stmt->execute();

            // 2. Mettre à jour la table avoir
            $query = "UPDATE avoir 
                     SET id_grade = :id_grade,
                         date_grade = :date_grade
                     WHERE id_enseignant = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_grade', $id_grade);
            $stmt->bindParam(':date_grade', $date_grade);
            $stmt->execute();

            // 3. Mettre à jour la table occuper
            $query = "UPDATE occuper 
                     SET id_fonction = :id_fonction,
                         date_occupation = :date_fonction
                     WHERE id_enseignant = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_fonction', $id_fonction);
            $stmt->bindParam(':date_fonction', $date_fonction);
            $stmt->execute();

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Erreur lors de la modification de l'enseignant: " . $e->getMessage());
            return false;
        }
    }

    public function supprimerEnseignant($id) {
        try {
            $this->db->beginTransaction();

            // Supprimer d'abord les enregistrements dans les tables de liaison
            $query = "DELETE FROM avoir WHERE id_enseignant = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $query = "DELETE FROM occuper WHERE id_enseignant = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Enfin, supprimer l'enseignant
            $query = "DELETE FROM enseignants WHERE id_enseignant = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Erreur lors de la suppression de l'enseignant: " . $e->getMessage());
            return false;
        }
    }

    
}