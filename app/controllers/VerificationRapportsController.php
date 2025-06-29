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
            // Récupérer les rapports déposés pour le total
            $rapports = $this->rapportModel->getRapportsDeposes();
            
            // Compter les approbations et désapprobations dans la table approuver
            $stmtApprouve = $this->pdo->prepare("
                SELECT COUNT(DISTINCT id_rapport) as total_approuve 
                FROM approuver 
                WHERE decision = 'approuve'
            ");
            $stmtApprouve->execute();
            $totalApprouve = $stmtApprouve->fetchColumn();
            
            $stmtDesapprouve = $this->pdo->prepare("
                SELECT COUNT(DISTINCT id_rapport) as total_desapprouve 
                FROM approuver 
                WHERE decision = 'desapprouve'
            ");
            $stmtDesapprouve->execute();
            $totalDesapprouve = $stmtDesapprouve->fetchColumn();
            
            $stats = [
                'total' => count($rapports),
                'approuve' => $totalApprouve,
                'desapprouve' => $totalDesapprouve
            ];
            
            return $stats;
        } catch (Exception $e) {
            error_log("Erreur lors du calcul des statistiques: " . $e->getMessage());
            return [
                'total' => 0,
                'approuve' => 0,
                'desapprouve' => 0
            ];
        }
    }
    
    /**
     * Valider un rapport (approuver)
     */
    public function validerRapport() {
        try {
            error_log("DEBUG: Début validerRapport");
            
            $id_rapport = $_POST['id_rapport'] ?? 0;
            $commentaire = $_POST['commentaire'] ?? '';
            $id_admin = $_SESSION['id_utilisateur'] ?? 0;
            
            error_log("DEBUG: id_rapport = $id_rapport, commentaire = $commentaire, id_admin = $id_admin");
            
            if (!$id_rapport || !$commentaire || !$id_admin) {
                error_log("DEBUG: Paramètres manquants");
                return ['success' => false, 'message' => 'Paramètres manquants'];
            }
            
            // Récupérer l'ID du personnel admin
            $persAdmin = $this->persAdminModel->getByUserId($id_admin);
            error_log("DEBUG: persAdmin = " . print_r($persAdmin, true));
            
            if (!$persAdmin) {
                // Essayer une approche alternative : récupérer par l'email de l'utilisateur connecté
                error_log("DEBUG: Tentative de récupération alternative du personnel admin");
                $email_utilisateur = $_SESSION['email_utilisateur'] ?? '';
                if ($email_utilisateur) {
                    $persAdmin = $this->persAdminModel->getPersAdminByLogin($email_utilisateur);
                    error_log("DEBUG: persAdmin par email = " . print_r($persAdmin, true));
                }
            }
            
            if (!$persAdmin) {
                error_log("DEBUG: Personnel administratif non trouvé");
                return ['success' => false, 'message' => 'Personnel administratif non trouvé. Veuillez vérifier votre profil.'];
            }
            
            // Insérer l'approbation dans la table approuver
            error_log("DEBUG: Tentative d'insertion d'approbation");
            $result = $this->approbationModel->insererApprobation(
                $persAdmin['id_pers_admin'],
                $id_rapport,
                'Approuvé',
                $commentaire
            );
            
            error_log("DEBUG: Résultat insertion = " . ($result ? 'true' : 'false'));
            
            if ($result) {
                // Mettre à jour le statut du rapport
                $updateStmt = $this->pdo->prepare("UPDATE rapport_etudiants SET statut_rapport = 'valide' WHERE id_rapport = ?");
                $updateResult = $updateStmt->execute([$id_rapport]);
                error_log("DEBUG: Mise à jour statut = " . ($updateResult ? 'true' : 'false'));
                
                // Envoyer un email à l'étudiant
                $this->envoyerEmailNotification($id_rapport, 'approuve', $commentaire);
                
                return ['success' => true, 'message' => 'Rapport approuvé avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de l\'approbation'];
            }
            
        } catch (Exception $e) {
            error_log("Erreur approbation rapport: " . $e->getMessage());
            error_log("DEBUG: Stack trace: " . $e->getTraceAsString());
            return ['success' => false, 'message' => 'Erreur lors de l\'approbation: ' . $e->getMessage()];
        }
    }
    
    /**
     * Rejeter un rapport (désapprouver)
     */
    public function rejeterRapport() {
        try {
            error_log("DEBUG: Début rejeterRapport");
            
            $id_rapport = $_POST['id_rapport'] ?? 0;
            $commentaire = $_POST['commentaire'] ?? '';
            $id_admin = $_SESSION['id_utilisateur'] ?? 0;
            
            error_log("DEBUG: id_rapport = $id_rapport, commentaire = $commentaire, id_admin = $id_admin");
            
            if (!$id_rapport || !$commentaire || !$id_admin) {
                error_log("DEBUG: Paramètres manquants");
                return ['success' => false, 'message' => 'Paramètres manquants'];
            }
            
            // Récupérer l'ID du personnel admin
            $persAdmin = $this->persAdminModel->getByUserId($id_admin);
            error_log("DEBUG: persAdmin = " . print_r($persAdmin, true));
            
            if (!$persAdmin) {
                // Essayer une approche alternative : récupérer par l'email de l'utilisateur connecté
                error_log("DEBUG: Tentative de récupération alternative du personnel admin");
                $email_utilisateur = $_SESSION['email_utilisateur'] ?? '';
                if ($email_utilisateur) {
                    $persAdmin = $this->persAdminModel->getPersAdminByLogin($email_utilisateur);
                    error_log("DEBUG: persAdmin par email = " . print_r($persAdmin, true));
                }
            }
            
            if (!$persAdmin) {
                error_log("DEBUG: Personnel administratif non trouvé");
                return ['success' => false, 'message' => 'Personnel administratif non trouvé. Veuillez vérifier votre profil.'];
            }
            
            // Insérer l'approbation dans la table approuver
            error_log("DEBUG: Tentative d'insertion d'approbation");
            $result = $this->approbationModel->insererApprobation(
                $persAdmin['id_pers_admin'],
                $id_rapport,
                'Rejeté',
                $commentaire
            );
            
            error_log("DEBUG: Résultat insertion = " . ($result ? 'true' : 'false'));
            
            if ($result) {
                // Mettre à jour le statut du rapport
                $updateStmt = $this->pdo->prepare("UPDATE rapport_etudiants SET statut_rapport = 'rejeter' WHERE id_rapport = ?");
                $updateResult = $updateStmt->execute([$id_rapport]);
                error_log("DEBUG: Mise à jour statut = " . ($updateResult ? 'true' : 'false'));
                
                // Envoyer un email à l'étudiant
                $this->envoyerEmailNotification($id_rapport, 'desapprouve', $commentaire);
                
                return ['success' => true, 'message' => 'Rapport rejeté avec succès'];
            } else {
                return ['success' => false, 'message' => 'Erreur lors de la désapprobation.'];
            }
        } catch (Exception $e) {
            error_log("Erreur désapprobation rapport: " . $e->getMessage());
            error_log("DEBUG: Stack trace: " . $e->getTraceAsString());
            return ['success' => false, 'message' => 'Erreur lors de la désapprobation: ' . $e->getMessage()];
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

    /**
     * Envoyer un email de notification à l'étudiant
     */
    private function envoyerEmailNotification($id_rapport, $decision, $commentaire) {
        try {
            // Récupérer les informations du rapport et de l'étudiant
            $rapport = $this->rapportModel->getRapportDetail($id_rapport);
            if (!$rapport) {
                error_log("DEBUG: Rapport non trouvé pour l'envoi d'email");
                return false;
            }

            // Initialiser le service d'email
            $emailService = new EmailService();
            
            // Préparer le sujet et le message selon la décision
            if ($decision === 'approuve') {
                $sujet = "Votre rapport a été approuvé - Soutenance Manager";
                $message = $this->genererMessageEmailApprobation($rapport, $commentaire);
            } else {
                $sujet = "Votre rapport nécessite des modifications - Soutenance Manager";
                $message = $this->genererMessageEmailRejet($rapport, $commentaire);
            }

            // Envoyer l'email
            $resultat = $emailService->sendEmail($rapport->email_etu, $sujet, $message, true);
            
            if ($resultat) {
                error_log("DEBUG: Email envoyé avec succès à " . $rapport->email_etu);
            } else {
                error_log("DEBUG: Échec de l'envoi d'email à " . $rapport->email_etu);
            }
            
            return $resultat;
        } catch (Exception $e) {
            error_log("Erreur envoi email notification: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Générer le message HTML pour l'approbation
     */
    private function genererMessageEmailApprobation($rapport, $commentaire) {
        $nomComplet = $rapport->nom_etu . ' ' . $rapport->prenom_etu;
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #10B981; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
                .content { background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
                .footer { text-align: center; color: #666; font-size: 14px; }
                .success-icon { font-size: 48px; margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <div class='success-icon'>🎉</div>
                    <h1>Rapport Approuvé !</h1>
                </div>
                
                <div class='content'>
                    <p>Bonjour <strong>{$nomComplet}</strong>,</p>
                    
                    <p>Nous avons le plaisir de vous informer que votre rapport de soutenance a été <strong>approuvé</strong> par le personnel administratif.</p>
                    
                    <h3>Détails du rapport :</h3>
                    <ul>
                        <li><strong>Titre :</strong> {$rapport->nom_rapport}</li>
                        <li><strong>Thème :</strong> {$rapport->theme_rapport}</li>
                        <li><strong>Date de dépôt :</strong> " . date('d/m/Y', strtotime($rapport->date_depot)) . "</li>
                    </ul>
                    
                    <h3>Commentaire de l'évaluateur :</h3>
                    <p><em>" . htmlspecialchars($commentaire) . "</em></p>
                    
                    <p>Votre rapport est maintenant approuvé et il va être examiné par la commission de validation.</p>
                    
                    <p>Pour toute question, n'hésitez pas à contacter le service pédagogique.</p>
                </div>
                
                <div class='footer'>
                    <p>Cordialement,<br>L'équipe Soutenance Manager</p>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Générer le message HTML pour le rejet
     */
    private function genererMessageEmailRejet($rapport, $commentaire) {
        $nomComplet = $rapport->nom_etu . ' ' . $rapport->prenom_etu;
        
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #EF4444; color: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
                .content { background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
                .footer { text-align: center; color: #666; font-size: 14px; }
                .warning-icon { font-size: 48px; margin-bottom: 10px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <div class='warning-icon'>⚠️</div>
                    <h1>Rapport Nécessite des Modifications</h1>
                </div>
                
                <div class='content'>
                    <p>Bonjour <strong>{$nomComplet}</strong>,</p>
                    
                    <p>Nous vous informons que votre rapport de soutenance nécessite des modifications avant d'être approuvé.</p>
                    
                    <h3>Détails du rapport :</h3>
                    <ul>
                        <li><strong>Titre :</strong> {$rapport->nom_rapport}</li>
                        <li><strong>Thème :</strong> {$rapport->theme_rapport}</li>
                        <li><strong>Date de dépôt :</strong> " . date('d/m/Y', strtotime($rapport->date_depot)) . "</li>
                    </ul>
                    
                    <h3>Commentaire de l'évaluateur :</h3>
                    <p><em>" . htmlspecialchars($commentaire) . "</em></p>
                    
                    <p>Veuillez apporter les modifications demandées et soumettre une nouvelle version de votre rapport.</p>
                    
                    <p>Pour toute question ou clarification, n'hésitez pas à contacter le service pédagogique.</p>
                </div>
                
                <div class='footer'>
                    <p>Cordialement,<br>L'équipe Soutenance Manager</p>
                </div>
            </div>
        </body>
        </html>";
    }
} 