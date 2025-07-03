<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Approuver.php';
require_once __DIR__ . '/../models/AuditLog.php';

class VerificationCandidaturesSoutenanceController {
    private $approbationModel;
    private $auditLog;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        $this->approbationModel = new Approuver($this->pdo);
        $this->auditLog = new AuditLog($this->pdo);
    }

    /**
     * Approuver un rapport (communication)
     */
    public function approuverRapport() {
        try {
            $id_rapport = $_POST['id_rapport'] ?? 0;
            $commentaire = $_POST['commentaire'] ?? '';
            $id_admin = $_SESSION['id_utilisateur'] ?? 0;
            $id_approb = 3; // Niveau communication

            if (!$id_rapport || !$commentaire || !$id_admin) {
                return ['success' => false, 'message' => 'Paramètres manquants'];
            }

            if (!$this->approbationModel->approuverRapport($id_rapport, $id_admin, $id_approb, 'approuve', $commentaire)) {
                $errorInfo = $this->pdo->errorInfo();
                return ['success' => false, 'message' => "Erreur lors de l'enregistrement dans la table approuver: " . print_r($errorInfo, true)];
            }

            $this->auditLog->logValidation($id_admin, 'approuver', 'Succès');
            return ['success' => true, 'message' => 'Rapport approuvé (communication) avec succès'];
        } catch (Exception $e) {
            error_log("Erreur approbation rapport (communication): " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de l\'approbation (communication)'];
        }
    }

    /**
     * Désapprouver un rapport (communication)
     */
    public function rejeterRapport() {
        try {
            $id_rapport = $_POST['id_rapport'] ?? 0;
            $commentaire = $_POST['commentaire'] ?? '';
            $id_admin = $_SESSION['id_utilisateur'] ?? 0;
            $id_approb = 3; // Niveau communication

            if (!$id_rapport || !$commentaire || !$id_admin) {
                return ['success' => false, 'message' => 'Paramètres manquants'];
            }

            if (!$this->approbationModel->approuverRapport($id_rapport, $id_admin, $id_approb, 'desapprouve', $commentaire)) {
                $errorInfo = $this->pdo->errorInfo();
                return ['success' => false, 'message' => "Erreur lors de l'enregistrement dans la table approuver: " . print_r($errorInfo, true)];
            }

            $this->auditLog->logRejet($id_admin, 'approuver', 'Succès');
            return ['success' => true, 'message' => 'Rapport désapprouvé (communication) avec succès'];
        } catch (Exception $e) {
            error_log("Erreur désapprobation rapport (communication): " . $e->getMessage());
            return ['success' => false, 'message' => 'Erreur lors de la désapprobation (communication)'];
        }
    }
} 