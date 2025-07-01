<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RapportEtudiants.php';
require_once __DIR__ . '/../models/Valider.php';
require_once __DIR__ . '/../models/Approuver.php';
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/EvaluationRapport.php';

class EvaluationDossiersController {
    
    public function index() {
        $stats = $this->getStatistiques();
        $dossiers = $this->getDossiersAEvaluer();
        
        return [
            'stats' => $stats,
            'dossiers' => $dossiers
        ];
    }
    
    private function getStatistiques() {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total
            FROM rapport_etudiants r
            JOIN deposer d ON r.id_rapport = d.id_rapport
            WHERE r.etape_validation = 'approuve_communication' or r.etape_validation = 'en_attente_commission'
        ");
        $stmt->execute();
        $aEvaluer = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total
            FROM rapport_etudiants r
            WHERE r.etape_validation = 'valide'
        ");
        $stmt->execute();
        $valides = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        $stmt = $pdo->prepare("
            SELECT COUNT(*) as total
            FROM rapport_etudiants r
            WHERE r.etape_validation = 'desapprouve_commission'
        ");
        $stmt->execute();
        $aCorriger = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return [
            'a_evaluer' => $aEvaluer,
            'valides' => $valides,
            'a_corriger' => $aCorriger,
            'moyenne' => '14.5/20'
        ];
    }
    
    private function getDossiersAEvaluer() {
        $evaluationRapport = new EvaluationRapport();
        return $evaluationRapport->getRapportsAvecStatutVote();
    }
    
    public function traiterAction() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        register_shutdown_function(function() {
            $error = error_get_last();
            if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Erreur fatale PHP: ' . $error['message'] . ' dans ' . $error['file'] . ' ligne ' . $error['line']
                ]);
            }
        });
        
        try {
            error_log("DEBUG: traiterAction appelée");
            error_log("DEBUG: GET params: " . print_r($_GET, true));
            error_log("DEBUG: POST params: " . print_r($_POST, true));
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $action = $_POST['action'] ?? $_GET['action'] ?? '';
                error_log("DEBUG: Action récupérée: '$action'");
                
                switch ($action) {
                    case 'valider_dossier':
                        $this->validerDossier($_POST['id_rapport']);
                        break;
                    case 'rejeter_dossier':
                        $this->rejeterDossier($_POST['id_rapport'], $_POST['commentaire']);
                        break;
                    case 'traiter_decision':
                        // Correction : chaque membre enregistre son avis, sans rendre la décision finale
                        $decision = $_POST['decision'] ?? '';
                        $id_rapport = $_POST['id_rapport'] ?? '';
                        $commentaire = $_POST['commentaire'] ?? '';
                        $this->traiterDecisionCommission($id_rapport, $decision, $commentaire);
                        break;
                    case 'finaliser_decision':
                        $this->finaliserDecisionCommission($_POST['id_rapport']);
                        break;
                    case 'get_statistiques':
                        echo json_encode($this->getStatistiques());
                        break;
                    default:
                        echo json_encode(['success' => false, 'message' => 'Action non reconnue: "' . $action . '"']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Exception: ' . $e->getMessage() . ' dans ' . $e->getFile() . ' ligne ' . $e->getLine()
            ]);
        } catch (Error $e) {
            echo json_encode([
                'success' => false, 
                'message' => 'Erreur PHP: ' . $e->getMessage() . ' dans ' . $e->getFile() . ' ligne ' . $e->getLine()
            ]);
        }
    }
    
    private function getEnseignantIdFromAdmin($id_utilisateur) {
        $pdo = Database::getConnection();
        
        error_log("DEBUG: ID Utilisateur reçu: " . $id_utilisateur);
        
        $stmt = $pdo->prepare("SELECT login_utilisateur FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$id_utilisateur]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$utilisateur) {
            error_log("DEBUG: Utilisateur avec ID $id_utilisateur non trouvé");
            $stmt = $pdo->query("SELECT id_enseignant FROM enseignants LIMIT 1");
            $fallback = $stmt->fetch(PDO::FETCH_ASSOC);
            return $fallback ? $fallback['id_enseignant'] : null;
        }
        
        error_log("DEBUG: Login de l'utilisateur: " . $utilisateur['login_utilisateur']);
        
        $stmt = $pdo->prepare("
            SELECT e.id_enseignant, e.nom_enseignant, e.prenom_enseignant
            FROM enseignants e 
            WHERE e.mail_enseignant = ?
        ");
        $stmt->execute([$utilisateur['login_utilisateur']]);
        $enseignant = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($enseignant) {
            error_log("DEBUG: Enseignant trouvé: " . $enseignant['prenom_enseignant'] . " " . $enseignant['nom_enseignant'] . " (ID: " . $enseignant['id_enseignant'] . ")");
            return $enseignant['id_enseignant'];
        }
        
        error_log("DEBUG: Aucun enseignant trouvé avec le login: " . $utilisateur['login_utilisateur']);
        
        $stmt = $pdo->query("SELECT id_enseignant, nom_enseignant, prenom_enseignant FROM enseignants LIMIT 1");
        $fallback = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($fallback) {
            error_log("DEBUG: Utilisation du fallback - Enseignant: " . $fallback['prenom_enseignant'] . " " . $fallback['nom_enseignant'] . " (ID: " . $fallback['id_enseignant'] . ")");
            return $fallback['id_enseignant'];
        }
        
        error_log("DEBUG: Aucun enseignant disponible dans la base de données");
        return null;
    }
    
    private function validerDossier($id_rapport) {
        try {
            $pdo = Database::getConnection();
            
            error_log("DEBUG: Variables de session: " . print_r($_SESSION, true));
            
            $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;
            if (!$id_utilisateur) {
                echo json_encode(['success' => false, 'message' => 'Utilisateur non identifié']);
                return;
            }
            
            $id_enseignant = $this->getEnseignantIdFromAdmin($id_utilisateur);
            if (!$id_enseignant) {
                echo json_encode(['success' => false, 'message' => 'Aucun enseignant trouvé pour cet utilisateur']);
                return;
            }
            
            // Désactivé temporairement : mise à jour du statut du rapport
            // $stmt = $pdo->prepare("UPDATE rapport_etudiants SET etape_validation = 'valide', statut_rapport = 'valider' WHERE id_rapport = ?");
            // $stmt->execute([$id_rapport]);
            
            Valider::insererDecision($id_enseignant, $id_rapport, 'valider', 'Validé par la commission');
            
            echo json_encode(['success' => true, 'message' => 'Rapport validé avec succès']);
            
        } catch (Exception $e) {
            error_log("Erreur validerDossier: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la validation: ' . $e->getMessage()]);
        }
    }
    
    private function rejeterDossier($id_rapport, $commentaire) {
        try {
            $pdo = Database::getConnection();
            
            $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;
            if (!$id_utilisateur) {
                echo json_encode(['success' => false, 'message' => 'Utilisateur non identifié']);
                return;
            }
            
            $id_enseignant = $this->getEnseignantIdFromAdmin($id_utilisateur);
            if (!$id_enseignant) {
                echo json_encode(['success' => false, 'message' => 'Aucun enseignant trouvé pour cet utilisateur']);
                return;
            }
            
            // Désactivé temporairement : mise à jour du statut du rapport
            // $stmt = $pdo->prepare("UPDATE rapport_etudiants SET etape_validation = 'desapprouve_commission', statut_rapport = 'rejeter' WHERE id_rapport = ?");
            // $stmt->execute([$id_rapport]);
            
            Valider::insererDecision($id_enseignant, $id_rapport, 'rejeter', $commentaire);
            
            echo json_encode(['success' => true, 'message' => 'Rapport rejeté avec succès']);
            
        } catch (Exception $e) {
            error_log("Erreur rejeterDossier: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erreur lors du rejet: ' . $e->getMessage()]);
        }
    }
    
    private function traiterDecisionCommission($id_rapport, $decision, $commentaire = '') {
        try {
            $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;
            if (!$id_utilisateur) {
                echo json_encode(['success' => false, 'message' => 'Utilisateur non identifié']);
                return;
            }
            
            $id_enseignant = $this->getEnseignantIdFromAdmin($id_utilisateur);
            if (!$id_enseignant) {
                echo json_encode(['success' => false, 'message' => 'Enseignant non trouvé']);
                return;
            }
            
            error_log("DEBUG: Traitement décision commission - Rapport: $id_rapport, Décision: $decision, Enseignant: $id_enseignant");
            
            $evaluationRapport = new EvaluationRapport();
            
            $evaluationExistante = $evaluationRapport->evaluationExiste($id_rapport, $id_enseignant);
            
            if ($evaluationExistante) {
                $success = $evaluationRapport->mettreAJourEvaluation(
                    $evaluationExistante['id_evaluation'], 
                    $decision, 
                    $commentaire
                );
                error_log("DEBUG: Évaluation mise à jour");
            } else {
                $success = $evaluationRapport->ajouterEvaluation(
                    $id_rapport, 
                    $id_enseignant, 
                    $decision, 
                    $commentaire
                );
                error_log("DEBUG: Nouvelle évaluation créée");
            }
            
            if (!$success) {
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de l\'évaluation']);
                return;
            }
            
            $statutVote = $evaluationRapport->getStatutVotes($id_rapport);
            
            echo json_encode([
                'success' => true, 
                'message' => 'Votre évaluation a été enregistrée',
                'statut_vote' => $statutVote
            ]);
            
        } catch (Exception $e) {
            error_log("Erreur lors de l'enregistrement de l'évaluation: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de l\'évaluation: ' . $e->getMessage()]);
        }
    }
    
    private function finaliserDecisionCommission($id_rapport) {
        try {
            $evaluationRapport = new EvaluationRapport();
            
            $statutVote = $evaluationRapport->getStatutVotes($id_rapport);
            
            if (!$statutVote['peut_finaliser']) {
                echo json_encode(['success' => false, 'message' => 'Impossible de finaliser : vote en cours']);
                return;
            }
            
            $id_utilisateur = $_SESSION['id_utilisateur'] ?? null;
            if (!$id_utilisateur) {
                echo json_encode(['success' => false, 'message' => 'Utilisateur non identifié']);
                return;
            }
            
            $id_enseignant = $this->getEnseignantIdFromAdmin($id_utilisateur);
            if (!$id_enseignant) {
                echo json_encode(['success' => false, 'message' => 'Enseignant non trouvé']);
                return;
            }
            
            $decision = $statutVote['decision_finale'];
            
            if ($decision === 'valider') {
                $pdo = Database::getConnection();
                // Désactivé temporairement : mise à jour du statut du rapport
                // $stmt = $pdo->prepare("UPDATE rapport_etudiants SET etape_validation = 'valide', statut_rapport = 'valider' WHERE id_rapport = ?");
                // $stmt->execute([$id_rapport]);
                
                Valider::insererDecision($id_enseignant, $id_rapport, 'valider', 'Validé par consensus de la commission');
                
                echo json_encode(['success' => true, 'message' => 'Rapport validé par consensus de la commission']);
                
            } elseif ($decision === 'rejeter') {
                $pdo = Database::getConnection();
                // Désactivé temporairement : mise à jour du statut du rapport
                // $stmt = $pdo->prepare("UPDATE rapport_etudiants SET etape_validation = 'desapprouve_commission', statut_rapport = 'rejeter' WHERE id_rapport = ?");
                // $stmt->execute([$id_rapport]);
                
                Valider::insererDecision($id_enseignant, $id_rapport, 'rejeter', 'Rejeté par la commission');
                
                echo json_encode(['success' => true, 'message' => 'Rapport rejeté par la commission']);
            }
            
        } catch (Exception $e) {
            error_log("Erreur lors de la finalisation: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la finalisation: ' . $e->getMessage()]);
        }
    }
    
    public function detail($id_rapport) {
        $rapport = RapportEtudiants::getById($id_rapport);
        $decisions = Valider::getByRapport($id_rapport);
        return [
            'rapport' => $rapport,
            'decisions' => $decisions
        ];
    }
} 