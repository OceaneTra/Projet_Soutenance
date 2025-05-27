<?php

class Etudiants
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
      
    }

    public function ajouterEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu)
    {
        try {
            $this->db->beginTransaction();

            // 2. Insérer dans la table etudiants
            $query = "INSERT INTO etudiants (num_etu, nom_etu, prenom_etu, date_naiss_etu, genre_etu) 
                     VALUES (:num_etu, :nom_etu, :prenom_etu, :date_naiss_etu, :genre_etu)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->bindParam(':nom_etu', $nom_etu);
            $stmt->bindParam(':prenom_etu', $prenom_etu);
            $stmt->bindParam(':date_naiss_etu', $date_naiss_etu);
            $stmt->bindParam(':genre_etu', $genre_etu);
            $stmt->execute();

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erreur lors de l'ajout de l'étudiant: " . $e->getMessage());
            return false;
        }
    }

    public function updateEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu)
    {
        try {
            $query = "UPDATE etudiants 
                     SET nom_etu = :nom_etu, 
                         prenom_etu = :prenom_etu, 
                         date_naiss_etu = :date_naiss_etu, 
                         genre_etu = :genre_etu 
                     WHERE num_etu = :num_etu";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->bindParam(':nom_etu', $nom_etu);
            $stmt->bindParam(':prenom_etu', $prenom_etu);
            $stmt->bindParam(':date_naiss_etu', $date_naiss_etu);
            $stmt->bindParam(':genre_etu', $genre_etu);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'étudiant: " . $e->getMessage());
            return false;
        }
    }

    public function deleteEtudiant($num_etu)
    {
        try {
            $this->db->beginTransaction();

            // 1. Récupérer le login de l'étudiant
            $query = "SELECT login_etu FROM etudiants WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->execute();
            $login = $stmt->fetchColumn();

            // 2. Supprimer l'utilisateur
            if ($login) {
                $query = "DELETE FROM utilisateur WHERE login_utilisateur = :login";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':login', $login);
                $stmt->execute();
            }

            // 3. Supprimer l'étudiant
            $query = "DELETE FROM etudiants WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->execute();

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Erreur lors de la suppression de l'étudiant: " . $e->getMessage());
            return false;
        }
    }

    public function getEtudiantById($num_etu)
    {
        $query = "SELECT * FROM etudiants WHERE num_etu = :num_etu";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':num_etu', $num_etu);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllEtudiant()
    {
        try {
            $query = "SELECT * FROM etudiants ORDER BY num_etu DESC";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des étudiants: " . $e->getMessage());
            return [];
        }
    }

}