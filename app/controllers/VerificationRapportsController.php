<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RapportEtudiant.php';
require_once __DIR__ . '/../utils/EmailService.php';

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
            $commentaire = $_POST['commentaire'] ?? '';
            $id_pers_admin = $_SESSION['id_pers_admin'] ?? null;
            
            if (!$id_rapport) {
                return ['success' => false, 'message' => 'ID du rapport manquant'];
            }
            if (!$id_pers_admin) {
                return ['success' => false, 'message' => 'Identifiant administrateur manquant'];
            }
            
            $result = $this->rapportModel->updateStatutRapport($id_rapport, 'valide');
            $approb = $this->rapportModel->ajouterApprobation($id_pers_admin, $id_rapport, $commentaire);
            $rapport = $this->rapportModel->getRapportById($id_rapport);
            $emailSent = false;
            if ($rapport && !empty($rapport->email_etu)) {
                $emailService = new EmailService();
                $subject = "Votre rapport a été validé";
                $message = "Bonjour " . htmlspecialchars($rapport->prenom_etu . ' ' . $rapport->nom_etu) . ",<br><br>Votre rapport intitulé <b>" . htmlspecialchars($rapport->nom_rapport) . "</b> a été <b>validé</b>.<br><br>Commentaire :<br>" . nl2br(htmlspecialchars($commentaire)) . "<br><br>Cordialement.";
                $emailSent = $emailService->sendEmail($rapport->email_etu, $subject, $message, true);
            }
            
            if ($result && $approb) {
                $msg = 'Rapport validé avec succès.';
                if ($emailSent) $msg .= ' Un email a été envoyé à l\'étudiant.';
                else $msg .= ' (Email non envoyé)';
                return ['success' => true, 'message' => $msg];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de la validation ou de l\'approbation.'];
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
            $commentaire = $_POST['commentaire'] ?? '';
            $id_pers_admin = $_SESSION['id_pers_admin'] ?? null;
            
            if (!$id_rapport) {
                return ['success' => false, 'message' => 'ID du rapport manquant'];
            }
            if (!$id_pers_admin) {
                return ['success' => false, 'message' => 'Identifiant administrateur manquant'];
            }
            
            $result = $this->rapportModel->updateStatutRapport($id_rapport, 'rejete');
            $approb = $this->rapportModel->ajouterApprobation($id_pers_admin, $id_rapport, $commentaire);
            $rapport = $this->rapportModel->getRapportById($id_rapport);
            $emailSent = false;
            if ($rapport && !empty($rapport->email_etu)) {
                $emailService = new EmailService();
                $subject = "Votre rapport a été rejeté";
                $message = "Bonjour " . htmlspecialchars($rapport->prenom_etu . ' ' . $rapport->nom_etu) . ",<br><br>Votre rapport intitulé <b>" . htmlspecialchars($rapport->nom_rapport) . "</b> a été <b>rejeté</b>.<br><br>Commentaire :<br>" . nl2br(htmlspecialchars($commentaire)) . "<br><br>Cordialement.";
                $emailSent = $emailService->sendEmail($rapport->email_etu, $subject, $message, true);
            }
            
            if ($result && $approb) {
                $msg = 'Rapport rejeté avec succès.';
                if ($emailSent) $msg .= ' Un email a été envoyé à l\'étudiant.';
                else $msg .= ' (Email non envoyé)';
                return ['success' => true, 'message' => $msg];
            } else {
                return ['success' => false, 'message' => 'Erreur lors du rejet ou de l\'approbation.'];
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