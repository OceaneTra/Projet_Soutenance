<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RapportEtudiant.php';
require_once __DIR__ . '/../models/Approuver.php';
require_once __DIR__ . '/../models/PersAdmin.php';
require_once __DIR__ . '/../utils/EmailService.php';

class VerificationRapportsController {
    
    private $rapportModel;
    private $approbationModel;
    private $persAdminModel;
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->rapportModel = new RapportEtudiant($this->pdo);
        $this->approbationModel = new Approuver($this->pdo);
        $this->persAdminModel = new PersAdmin($this->pdo);
    }
    
    public function index() {
        try {
            // Récupérer les rapports déposés depuis la table deposer
            $rapports = $this->rapportModel->getRapportsDeposes();
            
            // Passer les données à la vue via les variables globales
            $GLOBALS['rapports'] = $rapports;
            $GLOBALS['nbRapports'] = count($rapports);
            
            // Statistiques des rapports par statut
            $stats = $this->getStatsRapports();
            $GLOBALS['statsRapports'] = $stats;
            
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des rapports: " . $e->getMessage());
            $GLOBALS['rapports'] = [];
            $GLOBALS['nbRapports'] = 0;
            $GLOBALS['statsRapports'] = [];
        }
    }
    
    /**
     * Récupère les statistiques des rapports par statut
     */
    private function getStatsRapports() {
        try {
            // Récupérer les rapports déposés
            $rapports = $this->rapportModel->getRapportsDeposes();
            
            $stats = [
                'total' => count($rapports),
                'en_attente' => 0,
                'en_cours' => 0,
                'valider' => 0,
                'rejeter' => 0
            ];
            
            foreach ($rapports as $rapport) {
                $statut = $rapport->statut_rapport ?? 'en_attente';
                if (isset($stats[$statut])) {
                    $stats[$statut]++;
                }
            }
            
            return $stats;
        } catch (Exception $e) {
            error_log("Erreur lors du calcul des statistiques: " . $e->getMessage());
            return [
                'total' => 0,
                'en_attente' => 0,
                'en_cours' => 0,
                'valider' => 0,
                'rejeter' => 0
            ];
        }
    }
    
    /**
     * Valider un rapport (approuver)
     */
    public function validerRapport() {
        try {
            $id_rapport = $_POST['id_rapport'] ?? 0;
            $commentaire = $_POST['commentaire'] ?? '';
            $id_admin = $_SESSION['id_utilisateur'] ?? 0;
            
            if (!$id_rapport || !$commentaire || !$id_admin) {
                return ['success' => false, 'message' => 'Paramètres manquants'];
            }
            
            // Insérer l'évaluation dans la table evaluations_rapports
            $stmt = $this->pdo->prepare("
                INSERT INTO evaluations_rapports (id_rapport, id_evaluateur, type_evaluateur, commentaire, statut_evaluation, date_evaluation) 
                VALUES (?, ?, 'personnel_admin', ?, 'terminee', NOW())
            ");
            
            if ($stmt->execute([$id_rapport, $id_admin, $commentaire])) {
                // Mettre à jour le statut du rapport
                $updateStmt = $this->pdo->prepare("UPDATE rapport_etudiants SET statut_rapport = 'valider' WHERE id_rapport = ?");
                $updateStmt->execute([$id_rapport]);
                
                return ['success' => true, 'message' => 'Rapport approuvé avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de l\'approbation'];
            }
            
        } catch (Exception $e) {
            error_log("Erreur approbation rapport: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de l\'approbation'];
        }
    }
    
    /**
     * Rejeter un rapport (désapprouver)
     */
    public function rejeterRapport() {
        try {
            $id_rapport = $_POST['id_rapport'] ?? 0;
            $commentaire = $_POST['commentaire'] ?? '';
            $id_admin = $_SESSION['id_utilisateur'] ?? 0;
            
            if (!$id_rapport || !$commentaire || !$id_admin) {
                return ['success' => false, 'message' => 'Paramètres manquants'];
            }
            
            // Insérer l'évaluation dans la table evaluations_rapports
            $stmt = $this->pdo->prepare("
                INSERT INTO evaluations_rapports (id_rapport, id_evaluateur, type_evaluateur, commentaire, statut_evaluation, date_evaluation) 
                VALUES (?, ?, 'personnel_admin', ?, 'terminee', NOW())
            ");
            
            if ($stmt->execute([$id_rapport, $id_admin, $commentaire])) {
                // Mettre à jour le statut du rapport
                $updateStmt = $this->pdo->prepare("UPDATE rapport_etudiants SET statut_rapport = 'rejeter' WHERE id_rapport = ?");
                $updateStmt->execute([$id_rapport]);
                
                return ['success' => true, 'message' => 'Rapport rejeté avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de la désapprobation.'];
            }
        } catch (Exception $e) {
            error_log("Erreur désapprobation rapport: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de la désapprobation'];
        }
    }
    
    /**
     * Récupérer les détails d'un rapport
     */
    public function getRapportDetail($id_rapport) {
        try {
            return $this->rapportModel->getRapportDetail($id_rapport);
        } catch (Exception $e) {
            error_log("Erreur récupération détail rapport: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Récupérer les décisions d'évaluation d'un rapport
     */
    public function getDecisionsEvaluation($id_rapport) {
        try {
            return $this->rapportModel->getDecisionsEvaluation($id_rapport);
        } catch (Exception $e) {
            error_log("Erreur récupération décisions évaluation: " . $e->getMessage());
            return [];
        }
    }
} 