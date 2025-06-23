<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RapportEtudiant.php';

class VerificationRapportsController {
    
    private $rapportModel;
    
    public function __construct() {
        $this->rapportModel = new RapportEtudiant(Database::getConnection());
    }
    
    public function index() {
        try {
            // Récupérer tous les rapports avec les informations des étudiants
            $rapports = $this->rapportModel->getAllRapports();
            
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
            $rapports = $this->rapportModel->getAllRapports();
            
            $stats = [
                'total' => count($rapports),
                'en_cours' => 0,
                'en_revision' => 0,
                'valide' => 0,
                'a_corriger' => 0,
                'rejete' => 0
            ];
            
            foreach ($rapports as $rapport) {
                $statut = $rapport->statut_rapport ?? 'en_cours';
                if (isset($stats[$statut])) {
                    $stats[$statut]++;
                }
            }
            
            return $stats;
        } catch (Exception $e) {
            error_log("Erreur lors du calcul des statistiques: " . $e->getMessage());
            return [
                'total' => 0,
                'en_cours' => 0,
                'en_revision' => 0,
                'valide' => 0,
                'a_corriger' => 0,
                'rejete' => 0
            ];
        }
    }
    
    /**
     * Valider un rapport
     */
    public function validerRapport() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Méthode non autorisée'];
        }
        
        try {
            $id_rapport = $_POST['id_rapport'] ?? 0;
            
            if (!$id_rapport) {
                return ['success' => false, 'message' => 'ID du rapport manquant'];
            }
            
            $result = $this->rapportModel->updateStatutRapport($id_rapport, 'valide');
            
            if ($result) {
                return ['success' => true, 'message' => 'Rapport validé avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de la validation'];
            }
        } catch (Exception $e) {
            error_log("Erreur validation rapport: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de la validation'];
        }
    }
    
    /**
     * Rejeter un rapport
     */
    public function rejeterRapport() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'message' => 'Méthode non autorisée'];
        }
        
        try {
            $id_rapport = $_POST['id_rapport'] ?? 0;
            
            if (!$id_rapport) {
                return ['success' => false, 'message' => 'ID du rapport manquant'];
            }
            
            $result = $this->rapportModel->updateStatutRapport($id_rapport, 'rejete');
            
            if ($result) {
                return ['success' => true, 'message' => 'Rapport rejeté avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors du rejet'];
            }
        } catch (Exception $e) {
            error_log("Erreur rejet rapport: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors du rejet'];
        }
    }
    
    /**
     * Récupérer les détails d'un rapport
     */
    public function getRapportDetail($id_rapport) {
        try {
            return $this->rapportModel->getRapportById($id_rapport);
        } catch (Exception $e) {
            error_log("Erreur récupération détail rapport: " . $e->getMessage());
            return null;
        }
    }
} 