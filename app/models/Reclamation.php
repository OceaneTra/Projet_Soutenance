<?php
require_once __DIR__ . '/../config/database.php';

class Reclamation {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function creer($donnees) {
        try {
            $sql = "INSERT INTO reclamations (
                        num_etu, 
                        id_utilisateur, 
                        titre_reclamation, 
                        description_reclamation, 
                        type_reclamation, 
                        priorite_reclamation, 
                        statut_reclamation, 
                        fichier_joint, 
                        date_creation, 
                        date_mise_a_jour
                    ) VALUES (
                        :num_etu, 
                        :id_utilisateur, 
                        :titre, 
                        :description, 
                        :type, 
                        :priorite, 
                        'En attente', 
                        :fichier, 
                        NOW(), 
                        NOW()
                    )";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_etu', $donnees['num_etu']);
            $stmt->bindParam(':id_utilisateur', $donnees['id_utilisateur']);
            $stmt->bindParam(':titre', $donnees['titre']);
            $stmt->bindParam(':description', $donnees['description']);
            $stmt->bindParam(':type', $donnees['type']);
            $stmt->bindParam(':priorite', $donnees['priorite']);
            $stmt->bindParam(':fichier', $donnees['fichier']);

            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de la réclamation : " . $e->getMessage());
            return false;
        }
    }

    public function getTous($limit = 10, $offset = 0, $filtres = []) {
        try {
            $sql = "SELECT r.*, 
                           CONCAT(e.nom_etu, ' ', e.prenom_etu) as nom_etu,
                           u.nom_utilisateur,
                           ua.nom_utilisateur as nom_admin_assigne
                    FROM reclamations r
                    LEFT JOIN etudiants e ON r.num_etu = e.num_etu
                    LEFT JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                    LEFT JOIN utilisateur ua ON r.id_admin_assigne = ua.id_utilisateur
                    WHERE 1=1";

            $params = [];

            if (isset($filtres['statut'])) {
                $sql .= " AND r.statut_reclamation = :statut";
                $params[':statut'] = $filtres['statut'];
            }

            if (isset($filtres['statut_multiple'])) {
                $placeholders = [];
                foreach ($filtres['statut_multiple'] as $index => $statut) {
                    $placeholder = ":statut{$index}";
                    $placeholders[] = $placeholder;
                    $params[$placeholder] = $statut;
                }
                $sql .= " AND r.statut_reclamation IN (" . implode(',', $placeholders) . ")";
            }

            if (isset($filtres['type'])) {
                $sql .= " AND r.type_reclamation = :type";
                $params[':type'] = $filtres['type'];
            }

            $sql .= " ORDER BY r.date_creation DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réclamations : " . $e->getMessage());
            return [];
        }
    }

    public function getParUtilisateur($userId, $typeUtilisateur) {
        try {
            if ($typeUtilisateur === 'etudiant') {
                $sql = "SELECT r.*, 
                               CONCAT(e.nom_etu, ' ', e.prenom_etu) as nom_etu
                        FROM reclamations r
                        LEFT JOIN etudiants e ON r.num_etu = e.num_etu
                        WHERE r.num_etu = :user_id
                        ORDER BY r.date_creation DESC";
            } else {
                $sql = "SELECT r.*, 
                               CONCAT(e.nom_etu, ' ', e.prenom_etu) as nom_etu,
                               u.nom_utilisateur
                        FROM reclamations r
                        LEFT JOIN etudiants e ON r.num_etu = e.num_etu
                        LEFT JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                        WHERE r.id_utilisateur = :user_id
                        ORDER BY r.date_creation DESC";
            }

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des réclamations utilisateur : " . $e->getMessage());
            return [];
        }
    }

    public function getParId($id) {
        try {
            $sql = "SELECT r.*, 
                           CONCAT(e.nom_etu, ' ', e.prenom_etu) as nom_etu,
                           e.email_etu,
                           u.nom_utilisateur,
                           ua.nom_utilisateur as nom_admin_assigne
                    FROM reclamations r
                    LEFT JOIN etudiants e ON r.num_etu = e.num_etu
                    LEFT JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                    LEFT JOIN utilisateur ua ON r.id_admin_assigne = ua.id_utilisateur
                    WHERE r.id_reclamation = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de la réclamation : " . $e->getMessage());
            return null;
        }
    }

    public function compterTotal($filtres = []) {
        try {
            $sql = "SELECT COUNT(*) FROM reclamations r WHERE 1=1";
            $params = [];

            if (isset($filtres['statut'])) {
                $sql .= " AND r.statut_reclamation = :statut";
                $params[':statut'] = $filtres['statut'];
            }

            if (isset($filtres['type'])) {
                $sql .= " AND r.type_reclamation = :type";
                $params[':type'] = $filtres['type'];
            }

            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur lors du comptage des réclamations : " . $e->getMessage());
            return 0;
        }
    }

    public function getStatistiques() {
        try {
            $sql = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN statut_reclamation = 'En attente' THEN 1 ELSE 0 END) as en_attente,
                        SUM(CASE WHEN statut_reclamation = 'En cours' THEN 1 ELSE 0 END) as en_cours,
                        SUM(CASE WHEN statut_reclamation = 'Résolue' THEN 1 ELSE 0 END) as resolues,
                        SUM(CASE WHEN statut_reclamation = 'Rejetée' THEN 1 ELSE 0 END) as rejetees
                    FROM reclamations";

            $stmt = $this->db->query($sql);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des statistiques : " . $e->getMessage());
            return [
                'total' => 0,
                'en_attente' => 0,
                'en_cours' => 0,
                'resolues' => 0,
                'rejetees' => 0
            ];
        }
    }

    public function mettreAJourStatut($id, $statut, $commentaire, $idAdmin) {
        try {
            $sql = "UPDATE reclamations 
                    SET statut_reclamation = :statut,
                        id_admin_assigne = :id_admin,
                        date_mise_a_jour = NOW()
                    WHERE id_reclamation = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':id_admin', $idAdmin);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                // Ajouter l'historique
                return $this->ajouterHistorique($id, $statut, $commentaire, $idAdmin);
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du statut : " . $e->getMessage());
            return false;
        }
    }

    public function ajouterHistorique($idReclamation, $action, $commentaire, $idUtilisateur) {
        try {
            $sql = "INSERT INTO historique_reclamations 
                    (id_reclamation, action, commentaire, id_utilisateur, date_action) 
                    VALUES (:id_rec, :action, :commentaire, :id_user, NOW())";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rec', $idReclamation);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->bindParam(':id_user', $idUtilisateur);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout à l'historique : " . $e->getMessage());
            return false;
        }
    }

    public function getHistorique($idReclamation) {
        try {
            $sql = "SELECT h.*, u.nom_utilisateur 
                    FROM historique_reclamations h
                    LEFT JOIN utilisateur u ON h.id_utilisateur = u.id_utilisateur
                    WHERE h.id_reclamation = :id
                    ORDER BY h.date_action DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $idReclamation);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'historique : " . $e->getMessage());
            return [];
        }
    }
}