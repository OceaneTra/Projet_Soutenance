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
                        titre_reclamation, 
                        description_reclamation, 
                        type_reclamation, 
                        priorite_reclamation, 
                        statut_reclamation
                    ) VALUES (
                        :num_etu, 
                        :titre, 
                        :description, 
                        :type, 
                        :priorite, 
                        'En attente'
                    )";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_etu', $donnees['num_etu']);
            $stmt->bindParam(':titre', $donnees['titre']);
            $stmt->bindParam(':description', $donnees['description']);
            $stmt->bindParam(':type', $donnees['type']);
            $stmt->bindParam(':priorite', $donnees['priorite']);

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
                           CONCAT(e.nom_etu, ' ', e.prenom_etu) as nom_etu
                    FROM reclamations r
                    LEFT JOIN etudiants e ON r.num_etu = e.num_etu
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


    public function getParId($id) {
        try {
            $sql = "SELECT r.*, 
                           CONCAT(e.nom_etu, ' ', e.prenom_etu) as nom_etu,
                           e.email_etu
                    FROM reclamations r
                    LEFT JOIN etudiants e ON r.num_etu = e.num_etu
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

    public function mettreAJourStatut($id, $statut, $commentaire, $numEtu) {
        try {
            $sql = "UPDATE reclamations 
                    SET statut_reclamation = :statut,
                        date_mise_a_jour = NOW()
                    WHERE id_reclamation = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                // Ajouter l'historique
                return $this->ajouterHistorique($id, $statut, $commentaire, $numEtu);
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour du statut : " . $e->getMessage());
            return false;
        }
    }

    public function ajouterHistorique($idReclamation, $action, $commentaire, $numEtu) {
        try {
            $sql = "INSERT INTO historique_reclamations 
                    (id_reclamation, action, commentaire, num_etu, date_action) 
                    VALUES (:id_rec, :action, :commentaire, :num_etu, NOW())";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id_rec', $idReclamation);
            $stmt->bindParam(':action', $action);
            $stmt->bindParam(':commentaire', $commentaire);
            $stmt->bindParam(':num_etu', $numEtu);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout à l'historique : " . $e->getMessage());
            return false;
        }
    }

    public function getHistorique($idReclamation, $numEtu) {
        try {
            $sql = "SELECT h.*, e.nom_etu, e.prenom_etu
                    FROM historique_reclamations h
                    LEFT JOIN etudiants e ON h.num_etu = e.num_etu
                    WHERE h.id_reclamation = :id
                    ORDER BY h.date_action DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $idReclamation);
            $stmt->bindParam(':num_etu', $numEtu);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'historique : " . $e->getMessage());
            return [];
        }
    }

    public function getAllReclamationsWithEtudiant() {
        $sql = "SELECT r.*, e.nom_etu, e.prenom_etu
                FROM reclamations r
                JOIN etudiants e ON r.num_etu = e.num_etu
                ORDER BY r.date_creation DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateStatut($id, $statut) {
        $sql = "UPDATE reclamations SET statut = ? WHERE id_reclamation = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$statut, $id]);
    }
}