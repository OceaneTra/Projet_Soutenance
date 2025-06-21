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

    public function getAllListeEtudiants() {
        try {
            $query = "SELECT e.*, n.lib_niv_etude, n.id_niv_etude, a.id_annee_acad, a.date_deb, a.date_fin
                      FROM etudiants e
                      LEFT JOIN inscriptions i ON e.num_etu = i.id_etudiant
                      LEFT JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude
                      LEFT JOIN annee_academique a ON i.id_annee_acad = a.id_annee_acad
                      WHERE i.id_inscription = (
                          SELECT i2.id_inscription FROM inscriptions i2
                          WHERE i2.id_etudiant = e.num_etu
                          ORDER BY i2.date_inscription DESC LIMIT 1
                      )
                      ORDER BY e.nom_etu, e.prenom_etu";
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

    public function getEtudiantByLogin($login)
    {
        try {
            $query = "SELECT * FROM etudiants WHERE email_etu = :login";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':login', $login);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'étudiant : " . $e->getMessage());
            return null;
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
        
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCandidature($num_etu) {
        $sql = "SELECT * FROM candidature_soutenance WHERE num_etu = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllCandidature() {
        $sql = "SELECT cs.*, e.nom_etu, e.prenom_etu 
                FROM candidature_soutenance cs 
                INNER JOIN etudiants e ON e.num_etu = cs.num_etu 
                ORDER BY cs.date_candidature DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCandidature($etudiant_id) {
        $sql = "INSERT INTO candidature_soutenance (num_etu, date_candidature, statut_candidature) VALUES (?, NOW(), 'En attente')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$etudiant_id]);
    }

    public function getCompteRendu($etudiant_id) {
        $sql = "SELECT * FROM compte_rendu WHERE num_etu = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$etudiant_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    


    

    public function verifierCandidature($numEtu) {
        $resultats = [];
        
        // Vérifier les notes
        $notes = $this->getNotesEtudiant($numEtu);
        $resultats['notes'] = [
            'status' => $notes['moyenne'] >= 10 ? 'success' : 'error',
            'message' => $notes['moyenne'] >= 10 ? 
                'Moyenne générale suffisante (' . number_format($notes['moyenne'], 2) . ')' : 
                'Moyenne générale insuffisante (' . number_format($notes['moyenne'], 2) . ')'
        ];

        // Vérifier le stage
        $stage = $this->getInfoStage($numEtu);
        $resultats['stage'] = [
            'status' => !empty($stage) ? 'success' : 'error',
            'message' => !empty($stage) ? 
                'Informations de stage complètes' : 
                'Informations de stage manquantes'
        ];

        return $resultats;
    }

    public function traiterCandidature($numEtu, $decision, $commentaire = null) {
        try {
            $sql = "UPDATE candidature_soutenance 
                   SET statut_candidature = :decision, 
                       commentaire = :commentaire,
                       date_traitement = NOW()
                   WHERE num_etu = :num_etu";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':decision' => $decision,
                ':commentaire' => $commentaire,
                ':num_etu' => $numEtu
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors du traitement de la candidature: " . $e->getMessage());
            return false;
        }
    }

    public function ajouterHistoriqueCandidature($numEtu, $action, $commentaire = null) {
        try {
            $sql = "INSERT INTO historique_candidatures (num_etu, action, commentaire, date_action)
                   VALUES (:num_etu, :action, :commentaire, NOW())";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':num_etu' => $numEtu,
                ':action' => $action,
                ':commentaire' => $commentaire
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout dans l'historique: " . $e->getMessage());
            return false;
        }
    }

    public function getHistoriqueCandidature($numEtu = null) {
        try {
            $sql = "SELECT h.*, e.nom_etu, e.prenom_etu 
                   FROM historique_candidatures h
                   JOIN etudiants e ON h.num_etu = e.num_etu";
            
            if ($numEtu) {
                $sql .= " WHERE h.num_etu = :num_etu";
            }
            
            $sql .= " ORDER BY h.date_action DESC";
            
            $stmt = $this->db->prepare($sql);
            
            if ($numEtu) {
                $stmt->bindParam(':num_etu', $numEtu);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'historique: " . $e->getMessage());
            return [];
        }
    }

    public function getNotesEtudiant($numEtu) {
        try {
            $sql = "SELECT AVG(note) as moyenne 
                   FROM notes 
                   WHERE num_etu = :num_etu";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':num_etu' => $numEtu]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return [
                'moyenne' => $result['moyenne'] ?? 0
            ];
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des notes: " . $e->getMessage());
            return ['moyenne' => 0];
        }
    }


    public function getInfoStage($numEtu) {
        try {
            $sql = "SELECT * FROM info_stage WHERE num_etu = :num_etu";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':num_etu' => $numEtu]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des informations de stage: " . $e->getMessage());
            return null;
        }
    }
    
   


} 