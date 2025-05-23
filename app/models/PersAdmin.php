<?php


class PersAdmin{



    private $db;
    private $id_pers_admin;
    private $nom_pers_admin;
    private $prenom_pers_admin;
    private $email_pers_admin;
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Getters
    public function getIdPersAdmin() { return $this->id_pers_admin; }
    public function getNomPersAdmin() { return $this->nom_pers_admin; }
    public function getPrenomPersAdmin() { return $this->prenom_pers_admin; }
    public function getEmailPersAdmin() { return $this->email_pers_admin; }
   

    // Setters
    public function setIdPersAdmin($id) { $this->id_pers_admin = $id; }
    public function setNomPersAdmin($nom) { $this->nom_pers_admin = $nom; }
    public function setPrenomPersAdmin($prenom) { $this->prenom_pers_admin = $prenom; }
    public function setEmailPersAdmin($email) { $this->email_pers_admin = $email; }
  

    // Méthodes CRUD
    public function getAllPersAdmin() {
        $query = "SELECT pa.* FROM personnel_admin pa 
                 ORDER BY pa.nom_pers_admin, pa.prenom_pers_admin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPersAdminById($id) {
        $query = "SELECT pa.*
                 FROM personnel_admin pa 
                 WHERE pa.id_pers_admin = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ajouterPersAdmin($nom, $prenom, $email) {
        try {
            $query = "INSERT INTO personnel_admin (nom_pers_admin, prenom_pers_admin, email_pers_admin
                     ) 
                     VALUES (:nom, :prenom, :email)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du personnel administratif: " . $e->getMessage());
            return false;
        }
    }

    public function modifierPersAdmin($id, $nom, $prenom, $email) {
        try {
            $query = "UPDATE personnel_admin 
                     SET nom_pers_admin = :nom, 
                         prenom_pers_admin = :prenom, 
                         email_pers_admin = :email, 
                     WHERE id_pers_admin = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':email', $email);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification du personnel administratif: " . $e->getMessage());
            return false;
        }
    }

    public function supprimerPersAdmin($id) {
        try {
            $query = "DELETE FROM personnel_admin  WHERE id_pers_admin = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du personnel administratif: " . $e->getMessage());
            return false;
        }
    }

    
}