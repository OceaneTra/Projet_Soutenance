<?php
require_once __DIR__ . '/../config/database.php';

class Reclamation
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    // Créer une nouvelle réclamation
    public function creer($data)
    {
        try {
            // Debug : afficher les données reçues
            error_log("Modèle Reclamation - Données reçues: " . print_r($data, true));

            // Vérifier la connexion à la base
            if (!$this->pdo) {
                error_log("Erreur : Pas de connexion à la base de données");
                return false;
            }

            // Vérifier que la table existe
            $checkTable = "SHOW TABLES LIKE 'reclamations'";
            $stmt = $this->pdo->query($checkTable);
            if ($stmt->rowCount() == 0) {
                error_log("Erreur : La table 'reclamations' n'existe pas");
                return false;
            }

            $sql = "INSERT INTO reclamations (num_etu, id_utilisateur, titre_reclamation, description_reclamation, 
                type_reclamation, priorite_reclamation, fichier_joint) 
                VALUES (:num_etu, :id_utilisateur, :titre, :description, :type, :priorite, :fichier)";

            error_log("SQL à exécuter: " . $sql);

            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':num_etu' => $data['num_etu'] ?? null,
                ':id_utilisateur' => $data['id_utilisateur'] ?? null,
                ':titre' => $data['titre'],
                ':description' => $data['description'],
                ':type' => $data['type'],
                ':priorite' => $data['priorite'],
                ':fichier' => $data['fichier'] ?? null
            ];

            error_log("Paramètres: " . print_r($params, true));

            $result = $stmt->execute($params);

            if ($result) {
                $reclamationId = $this->pdo->lastInsertId();
                error_log("Réclamation créée avec succès, ID: " . $reclamationId);

                // Ajouter à l'historique
                $this->ajouterHistorique($reclamationId, 'Création de la réclamation', null, 'En attente',
                    'Réclamation créée', $data['id_utilisateur'] ?? $data['num_etu']);

                return $reclamationId;
            } else {
                error_log("Échec de l'insertion - execute() a retourné false");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erreur PDO création réclamation : " . $e->getMessage());
            error_log("Code erreur PDO: " . $e->getCode());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        } catch (Exception $e) {
            error_log("Erreur générale création réclamation : " . $e->getMessage());
            return false;
        }
    }


    // Récupérer toutes les réclamations avec pagination
    public function getTous($limit = 10, $offset = 0, $filtres = [])
    {
        try {
            $conditions = [];
            $params = [];

            // Filtres
            if (!empty($filtres['statut'])) {
                $conditions[] = "r.statut_reclamation = :statut";
                $params[':statut'] = $filtres['statut'];
            }
            if (!empty($filtres['type'])) {
                $conditions[] = "r.type_reclamation = :type";
                $params[':type'] = $filtres['type'];
            }
            if (!empty($filtres['priorite'])) {
                $conditions[] = "r.priorite_reclamation = :priorite";
                $params[':priorite'] = $filtres['priorite'];
            }
            if (!empty($filtres['date_debut'])) {
                $conditions[] = "DATE(r.date_creation) >= :date_debut";
                $params[':date_debut'] = $filtres['date_debut'];
            }
            if (!empty($filtres['date_fin'])) {
                $conditions[] = "DATE(r.date_creation) <= :date_fin";
                $params[':date_fin'] = $filtres['date_fin'];
            }

            $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

            $sql = "SELECT r.*, 
                           e.nom_etu, e.prenom_etu,
                           u.nom_utilisateur,
                           ua.nom_utilisateur as nom_admin_assigne
                    FROM reclamations r
                    LEFT JOIN etudiants e ON r.num_etu = e.num_etu
                    LEFT JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                    LEFT JOIN utilisateur ua ON r.id_admin_assigne = ua.id_utilisateur
                    {$whereClause}
                    ORDER BY r.date_creation DESC
                    LIMIT :limit OFFSET :offset";

            $stmt = $this->pdo->prepare($sql);

            // Bind des paramètres de filtres
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération réclamations : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer une réclamation par ID
    public function getParId($id)
    {
        try {
            $sql = "SELECT r.*, 
                           e.nom_etu, e.prenom_etu, e.mail_etu,
                           u.nom_utilisateur,
                           ua.nom_utilisateur as nom_admin_assigne
                    FROM reclamations r
                    LEFT JOIN etudiants e ON r.num_etu = e.num_etu
                    LEFT JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                    LEFT JOIN utilisateur ua ON r.id_admin_assigne = ua.id_utilisateur
                    WHERE r.id_reclamation = :id";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération réclamation : " . $e->getMessage());
            return false;
        }
    }

    // Récupérer les réclamations d'un utilisateur
    public function getParUtilisateur($userId, $userType = 'etudiant')
    {
        try {
            if ($userType === 'etudiant') {
                $sql = "SELECT * FROM reclamations WHERE num_etu = :user_id ORDER BY date_creation DESC";
            } else {
                $sql = "SELECT * FROM reclamations WHERE id_utilisateur = :user_id ORDER BY date_creation DESC";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':user_id' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération réclamations utilisateur : " . $e->getMessage());
            return [];
        }
    }

    // Mettre à jour le statut d'une réclamation
    public function mettreAJourStatut($id, $nouveauStatut, $reponseAdmin = null, $adminId = null)
    {
        try {
            // Récupérer l'ancien statut
            $reclamation = $this->getParId($id);
            if (!$reclamation) {
                return false;
            }

            $ancienStatut = $reclamation['statut_reclamation'];

            $sql = "UPDATE reclamations SET 
                    statut_reclamation = :statut,
                    date_mise_a_jour = NOW()";

            $params = [':statut' => $nouveauStatut, ':id' => $id];

            if ($reponseAdmin !== null) {
                $sql .= ", reponse_admin = :reponse";
                $params[':reponse'] = $reponseAdmin;
            }

            if ($adminId !== null) {
                $sql .= ", id_admin_assigne = :admin_id";
                $params[':admin_id'] = $adminId;
            }

            if ($nouveauStatut === 'Résolue') {
                $sql .= ", date_resolution = NOW()";
            }

            $sql .= " WHERE id_reclamation = :id";

            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);

            if ($result) {
                // Ajouter à l'historique
                $this->ajouterHistorique($id, 'Changement de statut', $ancienStatut, $nouveauStatut,
                    $reponseAdmin, $adminId);
            }

            return $result;
        } catch (PDOException $e) {
            error_log("Erreur mise à jour statut : " . $e->getMessage());
            return false;
        }
    }

    // Ajouter une entrée dans l'historique
    public function ajouterHistorique($reclamationId, $action, $ancienStatut, $nouveauStatut, $commentaire, $userId)
    {
        try {
            // Vérifier que la table historique existe
            $checkTable = "SHOW TABLES LIKE 'historique_reclamations'";
            $stmt = $this->pdo->query($checkTable);
            if ($stmt->rowCount() == 0) {
                error_log("Attention : La table 'historique_reclamations' n'existe pas");
                return true; // Ne pas faire échouer la création pour ça
            }

            $sql = "INSERT INTO historique_reclamations 
                (id_reclamation, action_effectuee, ancien_statut, nouveau_statut, commentaire, id_utilisateur_action)
                VALUES (:reclamation_id, :action, :ancien_statut, :nouveau_statut, :commentaire, :user_id)";

            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':reclamation_id' => $reclamationId,
                ':action' => $action,
                ':ancien_statut' => $ancienStatut,
                ':nouveau_statut' => $nouveauStatut,
                ':commentaire' => $commentaire,
                ':user_id' => $userId
            ];

            error_log("Ajout historique - Paramètres: " . print_r($params, true));

            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Erreur ajout historique : " . $e->getMessage());
            return false; // Ne pas faire échouer la création principale
        }
    }

    // Récupérer l'historique d'une réclamation
    public function getHistorique($reclamationId)
    {
        try {
            $sql = "SELECT h.*, u.nom_utilisateur
                    FROM historique_reclamations h
                    LEFT JOIN utilisateur u ON h.id_utilisateur_action = u.id_utilisateur
                    WHERE h.id_reclamation = :reclamation_id
                    ORDER BY h.date_action DESC";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':reclamation_id' => $reclamationId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération historique : " . $e->getMessage());
            return [];
        }
    }

    // Obtenir les statistiques des réclamations
    public function getStatistiques()
    {
        try {
            $stats = [];

            // Total des réclamations
            $sql = "SELECT COUNT(*) as total FROM reclamations";
            $stmt = $this->pdo->query($sql);
            $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Par statut
            $sql = "SELECT statut_reclamation, COUNT(*) as count FROM reclamations GROUP BY statut_reclamation";
            $stmt = $this->pdo->query($sql);
            $stats['par_statut'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Par type
            $sql = "SELECT type_reclamation, COUNT(*) as count FROM reclamations GROUP BY type_reclamation";
            $stmt = $this->pdo->query($sql);
            $stats['par_type'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Par priorité
            $sql = "SELECT priorite_reclamation, COUNT(*) as count FROM reclamations GROUP BY priorite_reclamation";
            $stmt = $this->pdo->query($sql);
            $stats['par_priorite'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Réclamations du mois
            $sql = "SELECT COUNT(*) as count FROM reclamations WHERE MONTH(date_creation) = MONTH(NOW()) AND YEAR(date_creation) = YEAR(NOW())";
            $stmt = $this->pdo->query($sql);
            $stats['ce_mois'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            return $stats;
        } catch (PDOException $e) {
            error_log("Erreur statistiques : " . $e->getMessage());
            return [];
        }
    }

    // Supprimer une réclamation
    public function supprimer($id, $userId)
    {
        try {
            // Ajouter à l'historique avant suppression
            $this->ajouterHistorique($id, 'Suppression de la réclamation', null, null,
                'Réclamation supprimée', $userId);

            $sql = "DELETE FROM reclamations WHERE id_reclamation = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Erreur suppression réclamation : " . $e->getMessage());
            return false;
        }
    }

    // Compter le total des réclamations (pour pagination)
    public function compterTotal($filtres = [])
    {
        try {
            $conditions = [];
            $params = [];

            if (!empty($filtres['statut'])) {
                $conditions[] = "statut_reclamation = :statut";
                $params[':statut'] = $filtres['statut'];
            }
            if (!empty($filtres['type'])) {
                $conditions[] = "type_reclamation = :type";
                $params[':type'] = $filtres['type'];
            }
            if (!empty($filtres['priorite'])) {
                $conditions[] = "priorite_reclamation = :priorite";
                $params[':priorite'] = $filtres['priorite'];
            }

            $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

            $sql = "SELECT COUNT(*) as total FROM reclamations {$whereClause}";
            $stmt = $this->pdo->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        } catch (PDOException $e) {
            error_log("Erreur comptage réclamations : " . $e->getMessage());
            return 0;
        }
    }
}