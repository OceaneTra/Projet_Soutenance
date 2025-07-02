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

    public function getCompteRendu($etudiant_id) {
        $sql = "SELECT * FROM compte_rendu WHERE num_etu = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$etudiant_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function traiterCandidature($numEtu, $decision, $commentaire,$id_pers_admin) {
        try {
            $sql = "UPDATE candidature_soutenance 
                   SET statut_candidature = :decision, 
                       commentaire_admin = :commentaire,
                       id_pers_admin = :id_pers_admin,
                       date_traitement = NOW()
                   WHERE id_candidature = :id_candidature";
            
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':decision' => $decision,
                ':commentaire' => $commentaire,
                ':id_pers_admin' => $id_pers_admin,
                ':id_candidature' => $numEtu
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors du traitement de la candidature: " . $e->getMessage());
            return false;
        }
    }
   

    public function getNotesEtudiant($numEtu) {
        try {
            // D'abord, récupérer le niveau d'étude de l'étudiant
            $sql_niveau = "SELECT i.id_niveau 
                          FROM inscriptions i 
                          WHERE i.id_etudiant = :num_etu 
                          AND i.id_annee_acad = (SELECT MAX(id_annee_acad) FROM annee_academique)";
            
            $stmt_niveau = $this->db->prepare($sql_niveau);
            $stmt_niveau->execute([':num_etu' => $numEtu]);
            $niveau_etudiant = $stmt_niveau->fetch(PDO::FETCH_ASSOC);
            
            if (!$niveau_etudiant) {
                return [
                    'moyenne' => 0,
                    'total_unites' => 0,
                    'unites_validees' => 0,
                    'resultats_disponibles' => false,
                    'message' => 'Niveau d\'étude non trouvé'
                ];
            }
            
            $id_niveau = $niveau_etudiant['id_niveau'];
            
            // Compter le nombre total d'UE pour ce niveau
            $sql_total_ue = "SELECT COUNT(*) as total_ue 
                            FROM ue 
                            WHERE id_niveau_etude = :id_niveau 
                            AND id_annee_academique = (SELECT MAX(id_annee_acad) FROM annee_academique)";
            
            $stmt_total_ue = $this->db->prepare($sql_total_ue);
            $stmt_total_ue->execute([':id_niveau' => $id_niveau]);
            $total_ue = $stmt_total_ue->fetch(PDO::FETCH_ASSOC)['total_ue'];
            
            // Compter le nombre d'UE où l'étudiant a des notes
            $sql_ue_avec_notes = "SELECT COUNT(DISTINCT u.id_ue) as ue_avec_notes 
                                 FROM ue u 
                                 JOIN notes n ON u.id_ue = n.id_ue 
                                 WHERE u.id_niveau_etude = :id_niveau 
                                 AND n.num_etu = :num_etu 
                                 AND u.id_annee_academique = (SELECT MAX(id_annee_acad) FROM annee_academique)";
            
            $stmt_ue_avec_notes = $this->db->prepare($sql_ue_avec_notes);
            $stmt_ue_avec_notes->execute([':id_niveau' => $id_niveau, ':num_etu' => $numEtu]);
            $ue_avec_notes = $stmt_ue_avec_notes->fetch(PDO::FETCH_ASSOC)['ue_avec_notes'];
            
            // Vérifier si l'étudiant a des notes dans toutes les UE
            $resultats_complets = ($ue_avec_notes == $total_ue && $total_ue > 0);
            
            if (!$resultats_complets) {
                return [
                    'moyenne' => 0,
                    'total_unites' => 0,
                    'unites_validees' => 0,
                    'resultats_disponibles' => false,
                    'message' => 'Résultats pas encore disponibles',
                    'ue_avec_notes' => $ue_avec_notes,
                    'total_ue' => $total_ue
                ];
            }
            
            // Si tous les résultats sont disponibles, calculer la moyenne
            $sql_moyenne = "SELECT AVG(n.moyenne) as moyenne 
                           FROM notes n 
                           JOIN ue u ON n.id_ue = u.id_ue
                           WHERE n.num_etu = :num_etu 
                           AND u.id_niveau_etude = :id_niveau
                           AND u.id_annee_academique = (SELECT MAX(id_annee_acad) FROM annee_academique)";
            
            $stmt_moyenne = $this->db->prepare($sql_moyenne);
            $stmt_moyenne->execute([':num_etu' => $numEtu, ':id_niveau' => $id_niveau]);
            $result = $stmt_moyenne->fetch(PDO::FETCH_ASSOC);
            
            // Récupérer les informations sur les crédits
            $sql_credits = "SELECT 
                            SUM(u.credit) as total_credits,
                            SUM(CASE WHEN n.moyenne >= 10 THEN u.credit ELSE 0 END) as credits_valides
                          FROM ue u
                          LEFT JOIN notes n ON u.id_ue = n.id_ue AND n.num_etu = :num_etu
                          WHERE u.id_niveau_etude = :id_niveau 
                          AND u.id_annee_academique = (SELECT MAX(id_annee_acad) FROM annee_academique)";
            
            $stmt_credits = $this->db->prepare($sql_credits);
            $stmt_credits->execute([':num_etu' => $numEtu, ':id_niveau' => $id_niveau]);
            $result_credits = $stmt_credits->fetch(PDO::FETCH_ASSOC);
            
            return [
                'moyenne' => $result['moyenne'] ?? 0,
                'total_unites' => $result_credits['total_credits'] ?? 0,
                'unites_validees' => $result_credits['credits_valides'] ?? 0,
                'resultats_disponibles' => true,
                'message' => 'Résultats disponibles'
            ];
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des notes: " . $e->getMessage());
            return [
                'moyenne' => 0,
                'total_unites' => 0,
                'unites_validees' => 0,
                'resultats_disponibles' => false,
                'message' => 'Erreur lors de la récupération des notes'
            ];
        }
    }


    public function getInfoStage($numEtu) {
        try {
            $sql = "SELECT infos_stage.*, e.lib_entreprise as nom_entreprise
                   FROM informations_stage infos_stage
                   JOIN entreprises e ON infos_stage.id_entreprise = e.id_entreprise
                   WHERE infos_stage.num_etu = :num_etu";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':num_etu' => $numEtu]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return [
                    'nom_entreprise' => $result['nom_entreprise'],
                    'sujet_stage' => $result['sujet_stage'],
                    'date_debut_stage' => $result['date_debut_stage'],
                    'date_fin_stage' => $result['date_fin_stage'],
                    'encadrant_entreprise' => $result['encadrant_entreprise']
                ];
            }
            return null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des informations de stage: " . $e->getMessage());
            return null;
        }
    }
    
   public function getEtudiantByNumEtu($numEtu) {
    $sql = "SELECT * FROM etudiants WHERE num_etu = :num_etu";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':num_etu' => $numEtu]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   public function getSemestreActuel($numEtu) {
        try {
            // Récupérer tous les semestres du niveau d'étude de l'étudiant
            $sql = "SELECT s.id_semestre, s.lib_semestre, n.lib_niv_etude
                   FROM inscriptions i
                   JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude
                   JOIN semestre s ON n.id_niv_etude = s.id_niv_etude
                   WHERE i.id_etudiant = :num_etu
                   AND i.id_annee_acad = (SELECT MAX(id_annee_acad) FROM annee_academique)
                   ORDER BY s.lib_semestre ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':num_etu' => $numEtu]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($result) {
                return [
                    'niveau' => $result[0]['lib_niv_etude'],
                    'semestres' => $result
                ];
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des semestres: " . $e->getMessage());
            return null;
        }
    }

    public function createCandidature($etudiant_id) {
        $sql = "INSERT INTO candidature_soutenance (num_etu, date_candidature, statut_candidature) VALUES (?, NOW(), 'En attente')";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$etudiant_id]);
    }

    /**
     * Enregistre ou met à jour le résumé de candidature pour un étudiant
     */
    public function saveResumeCandidature($id_candidature, $num_etu, $resume, $decision) {
        $sql = "INSERT INTO resume_candidature (id_candidature, num_etu, resume_json, decision, date_enregistrement)
                VALUES (:id_candidature, :num_etu, :resume_json, :decision, NOW())
                ON DUPLICATE KEY UPDATE resume_json = :resume_json, decision = :decision, date_enregistrement = NOW()";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_candidature' => $id_candidature,
            ':num_etu' => $num_etu,
            ':resume_json' => json_encode($resume),
            ':decision' => $decision
        ]);
    }

    /**
     * Récupère le résumé de candidature pour un étudiant
     */
    public function getResumeCandidature($id_candidature) {
        $sql = "SELECT * FROM resume_candidature WHERE id_candidature = ? ORDER BY date_enregistrement DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_candidature]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row['resume_json'] = json_decode($row['resume_json'], true);
        }
        return $row;
    }

    /**
     * Retourne toutes les candidatures d'un étudiant
     */
    public function getCandidatures($num_etu) {
        $sql = "SELECT * FROM candidature_soutenance WHERE num_etu = ? ORDER BY date_candidature DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$num_etu]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

      public function getLastCandidatureByNumEtu($num_etu) {
        $sql = "SELECT * FROM candidature_soutenance WHERE num_etu = ? ORDER BY date_candidature DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Calcule les moyennes majeures, mineures, la moyenne du semestre et la validation
     */
    public function getMoyennesSemestre($numEtu, $id_semestre) {
        // Récupérer toutes les notes d'UE de l'étudiant pour ce semestre
        $sql = "SELECT n.moyenne, u.credit
                FROM notes n
                JOIN ue u ON n.id_ue = u.id_ue
                WHERE n.num_etu = :num_etu
                  AND u.id_semestre = :id_semestre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':num_etu' => $numEtu, ':id_semestre' => $id_semestre]);
        $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $majeures = $mineures = [];
        foreach ($notes as $note) {
            if ($note['credit'] > 3) {
                $majeures[] = $note['moyenne'];
            } else {
                $mineures[] = $note['moyenne'];
            }
        }

        $moyenne_majeure = count($majeures) ? array_sum($majeures) / count($majeures) : 0;
        $moyenne_mineure = count($mineures) ? array_sum($mineures) / count($mineures) : 0;

        $semestre_valide = ($moyenne_majeure >= 10 && $moyenne_mineure >= 10);

        // Moyenne du semestre = moyenne arithmétique des deux
        $moyenne_semestre = ($moyenne_majeure + $moyenne_mineure) / 2;

        // Crédits attribués
        $credits = 0;
        if ($semestre_valide) {
            $sql = "SELECT SUM(credit) as total_credits FROM ue WHERE id_semestre = :id_semestre";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id_semestre' => $id_semestre]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $credits = $row['total_credits'] ?? 0;
        }

        return [
            'moyenne_majeure' => round($moyenne_majeure, 2),
            'moyenne_mineure' => round($moyenne_mineure, 2),
            'moyenne_semestre' => round($moyenne_semestre, 2),
            'semestre_valide' => $semestre_valide,
            'credits_attribues' => $credits
        ];
    }

    public function getNiveauByEtudiant($num_etu) {
        $query = "SELECT n.* FROM inscriptions i JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude WHERE i.id_etudiant = ? ORDER BY i.id_inscription DESC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

} 