<?php

class Etudiant {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllEtudiants() {
        try {
            $query = "SELECT * FROM etudiants ORDER BY nom_etu, prenom_etu";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des étudiants : " . $e->getMessage());
            return [];
        }
    }

    public function getEtudiantById($num_etu) {
        try {
            $query = "SELECT * FROM etudiants WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'étudiant : " . $e->getMessage());
            return null;
        }
    }

    

    public function isNumEtuExists($num_etu) {
        try {
            $query = "SELECT COUNT(*) FROM etudiants WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la vérification du numéro étudiant : " . $e->getMessage());
            return false;
        }
    }

    public function ajouterEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $email_etu, $promotion_etu) {
        try {
            $sql = "INSERT INTO etudiants (num_etu, nom_etu, prenom_etu, date_naiss_etu, genre_etu, email_etu, promotion_etu) 
                    VALUES (:num_etu, :nom_etu, :prenom_etu, :date_naiss_etu, :genre_etu, :email_etu, :promotion_etu)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->bindParam(':nom_etu', $nom_etu);
            $stmt->bindParam(':prenom_etu', $prenom_etu);
            $stmt->bindParam(':date_naiss_etu', $date_naiss_etu);
            $stmt->bindParam(':genre_etu', $genre_etu);
            $stmt->bindParam(':email_etu', $email_etu);
            $stmt->bindParam(':promotion_etu', $promotion_etu);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'étudiant : " . $e->getMessage());
            return false;
        }
    }

    public function modifierEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $email_etu, $promotion_etu) {
        try {
            $sql = "UPDATE etudiants 
                    SET nom_etu = :nom_etu, 
                        prenom_etu = :prenom_etu, 
                        date_naiss_etu = :date_naiss_etu, 
                        genre_etu = :genre_etu, 
                        email_etu = :email_etu,
                        promotion_etu = :promotion_etu
                    WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_etu', $num_etu);
            $stmt->bindParam(':nom_etu', $nom_etu);
            $stmt->bindParam(':prenom_etu', $prenom_etu);
            $stmt->bindParam(':date_naiss_etu', $date_naiss_etu);
            $stmt->bindParam(':genre_etu', $genre_etu);
            $stmt->bindParam(':email_etu', $email_etu);
            $stmt->bindParam(':promotion_etu', $promotion_etu);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification de l'étudiant : " . $e->getMessage());
            return false;
        }
    }

    public function supprimerEtudiant($num_etu) {
        try {
            $query = "DELETE FROM etudiants WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':num_etu', $num_etu);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'étudiant : " . $e->getMessage());
            return false;
        }
    }

    public function getEtudiantsByNiveau($niveauId) {
        $query = "SELECT e.*, n.lib_niv_etude as niveau_nom 
                 FROM etudiants e 
                 INNER JOIN inscriptions i ON e.num_etu = i.id_etudiant
                 INNER JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude 
                 WHERE i.id_niveau = :niveau_id 
                 ORDER BY e.nom_etu, e.prenom_etu";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':niveau_id', $niveauId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 