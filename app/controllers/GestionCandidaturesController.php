<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/Scolarite.php';
require_once __DIR__ . '/../models/InfoStage.php';
require_once __DIR__ . '/../models/PersAdmin.php';
require_once __DIR__ . '/../utils/EmailService.php';

class GestionCandidaturesController {
    private $db;
    private $etudiant;
    private $scolarite;
    private $emailService;

    private $pers_admin;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->etudiant = new Etudiant($this->db);
        $this->scolarite = new Scolarite($this->db);
        $this->emailService = new EmailService();
        $this->pers_admin = new PersAdmin($this->db);
    }
    
    public function index() {
        
        $GLOBALS['candidatures_soutenance'] = $this->etudiant->getAllCandidature();
    }

    // Méthode pour gérer l'examen d'une candidature
    public function examinerCandidature() {
        $examiner = $_GET['examiner'] ?? null;
        $id_candidature = $_GET['id_candidature'] ?? null;
        $etape = intval($_GET['etape'] ?? 1);
        $action = $_GET['action'] ?? '';

        // Démarrer la session pour stocker les étapes validées/rejetées
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Gestion des actions - DOIT être avant tout output HTML
        if ($action === 'valider_etape' && $examiner) {
            $etapeValidee = $_POST['etape'] ?? '';
            $_SESSION['etapes_validation'][$examiner][$etapeValidee] = 'validé';
            
            // Si c'est la dernière étape, aller au résumé final
            if ($etapeValidee == 3) {
                header("Location: ?page=gestion_candidatures_soutenance&examiner=$examiner&etape=4");
                exit;
            } else {
                // Passer à l'étape suivante
                header("Location: ?page=gestion_candidatures_soutenance&examiner=$examiner&etape=" . ($etape + 1));
                exit;
            }
        }

        if ($action === 'rejeter_etape' && $examiner) {
            $etapeRejetee = $_POST['etape'] ?? '';
            $_SESSION['etapes_validation'][$examiner][$etapeRejetee] = 'rejeté';
            
            // Passer à l'étape suivante même en cas de rejet
            if ($etapeRejetee < 3) {
                header("Location: ?page=gestion_candidatures_soutenance&examiner=$examiner&etape=" . ($etapeRejetee + 1));
            } else {
                // Si c'est la dernière étape, aller au résumé
                header("Location: ?page=gestion_candidatures_soutenance&examiner=$examiner&etape=4");
            }
            exit;
        }

        // Nouvelle action pour envoyer les résultats
        if ($action === 'envoyer_resultats' && $examiner) {
            $this->envoyerResultatsFinaux($examiner);
            header("Location: ?page=gestion_candidatures_soutenance&examiner=$examiner&etape=4&email_envoye=1");
            exit;
        }

        // Vérifier si l'étape précédente a été validée/rejetée
        $etapePrecedenteValidee = false;
        if ($etape > 1 && $etape < 4) {
            $etapePrecedenteValidee = isset($_SESSION['etapes_validation'][$examiner][$etape - 1]);
        }

        // Si l'étape précédente n'est pas validée et qu'on n'est pas au résumé final, rediriger vers l'étape précédente
        if ($etape > 1 && $etape < 4 && !$etapePrecedenteValidee) {
            header("Location: ?page=gestion_candidatures_soutenance&examiner=$examiner&etape=" . ($etape - 1));
            exit;
        }

        // Initialiser les étapes validées/rejetées pour cet étudiant
        if ($examiner && !isset($_SESSION['etapes_validation'][$examiner])) {
            $_SESSION['etapes_validation'][$examiner] = [];
        }

        // Données de l'étudiant à examiner
        $etudiantData = null;
        $etapeData = null;

        if ($examiner) {
            // Trouver l'étudiant dans les candidatures
            $etudiantData = $this->etudiant->getEtudiantByNumEtu($examiner);
            
            
            // Charger les données selon l'étape depuis la base de données
            if ($etudiantData) {
                switch ($etape) {
                    case 1: // Scolarité (anciennement étape 2)
                        $scolarite = $this->scolarite->getScolariteEtudiant($examiner);
                        $etapeData = [
                            'status' => ($scolarite && $scolarite['reste_a_payer'] > 0) ? 'En retard' : 'À jour',
                            'montant' => $scolarite ? number_format($scolarite['montant_total'], 0, ',', ' ') . ' FCFA' : '0 FCFA',
                            'montant_paye' => $scolarite ? number_format($scolarite['montant_paye'], 0, ',', ' ') . ' FCFA' : '0 FCFA',
                            'dernierPaiement' => ($scolarite && $scolarite['dernier_paiement']) ? date('d/m/Y', strtotime($scolarite['dernier_paiement'])) : 'Aucun paiement'
                        ];
                        break;
                        
                    case 2: // Stage (anciennement étape 3)
                        $stage = $this->etudiant->getInfoStage($examiner);
                        $etapeData = [
                            'entreprise' => $stage ? $stage['nom_entreprise'] : 'Non renseigné',
                            'sujet' => $stage ? $stage['sujet_stage'] : 'Non renseigné',
                            'periode' => $stage ? date('d/m/Y', strtotime($stage['date_debut_stage'])) . ' - ' . date('d/m/Y', strtotime($stage['date_fin_stage'])) : 'Non renseigné',
                            'encadrant' => $stage ? $stage['encadrant_entreprise'] : 'Non renseigné'
                        ];
                        break;
                        
                    case 3: // Semestre (anciennement étape 4)
                        $notes = $this->etudiant->getNotesEtudiant($examiner);
                        $semestre = $this->etudiant->getSemestreActuel($examiner);
                        $etapeData = [
                            'semestre' => $semestre ? $semestre['lib_semestre'] : 'Non renseigné',
                            'moyenne' => number_format($notes['moyenne'] ?? 0, 2) . '/20',
                            'unites' => ($notes['unites_validees'] ?? 0) . '/' . ($notes['total_unites'] ?? 0) . ' crédits du Master 2 validés'
                        ];
                        break;
                        
                    case 4: // Résumé final (anciennement étape 5)
                        $etapeData = $this->genererResumeFinal($examiner);
                        break;
                }
            }
        }

        // Passer les données à la vue
        $GLOBALS['examiner'] = $examiner;
        $GLOBALS['etape'] = $etape;
        $GLOBALS['etudiantData'] = $etudiantData;
        $GLOBALS['etapeData'] = $etapeData;
    }

    

    // Méthode pour envoyer les résultats finaux
    private function envoyerResultatsFinaux($examiner) {
        $resume = $this->genererResumeFinal($examiner);
        $decision = $this->determinerDecision($resume);

        $pers_admin = $this->pers_admin->getPersAdminByLogin($_SESSION['login_utilisateur']);

        // Récupérer la dernière candidature de l'étudiant
        $candidature = $this->etudiant->getLastCandidatureByNumEtu($examiner);
        $id_candidature = $candidature['id_candidature'] ?? null;

        // Mettre à jour le statut de la candidature
        $this->etudiant->traiterCandidature($id_candidature, $decision, 'Évaluation complète terminée', $pers_admin->id_pers_admin);

        // Enregistrer le résumé dans la table resume_candidature
        $this->etudiant->saveResumeCandidature($id_candidature, $examiner, $resume, $decision);

        // Envoyer l'email à l'étudiant avec le résumé complet
        $this->envoyerEmailResultat($examiner, $resume, $decision);

        // Marquer que l'email a été envoyé
        $_SESSION['email_envoye'][$examiner] = true;
    }

    // Méthode pour générer le résumé final
    private function genererResumeFinal($examiner) {
        $resume = [];
        
        // Récupérer les données de toutes les étapes
        $scolarite = $this->scolarite->getScolariteEtudiant($examiner);
        $stage = $this->etudiant->getInfoStage($examiner);
        $notes = $this->etudiant->getNotesEtudiant($examiner);
        
        // Étape 1 - Scolarité
        $resume['scolarite'] = [
            'statut' => ($scolarite && $scolarite['reste_a_payer'] > 0) ? 'En retard' : 'À jour',
            'montant_total' => $scolarite ? number_format($scolarite['montant_total'], 0, ',', ' ') . ' FCFA' : '0 FCFA',
            'montant_paye' => $scolarite ? number_format($scolarite['montant_paye'], 0, ',', ' ') . ' FCFA' : '0 FCFA',
            'dernier_paiement' => ($scolarite && $scolarite['dernier_paiement']) ? date('d/m/Y', strtotime($scolarite['dernier_paiement'])) : 'Aucun paiement',
            'validation' => $_SESSION['etapes_validation'][$examiner][1] ?? 'Non évalué'
        ];
        
        // Étape 2 - Stage
        $resume['stage'] = [
            'entreprise' => $stage ? $stage['nom_entreprise'] : 'Non renseigné',
            'sujet' => $stage ? $stage['sujet_stage'] : 'Non renseigné',
            'periode' => $stage ? date('d/m/Y', strtotime($stage['date_debut_stage'])) . ' - ' . date('d/m/Y', strtotime($stage['date_fin_stage'])) : 'Non renseigné',
            'encadrant' => $stage ? $stage['encadrant_entreprise'] : 'Non renseigné',
            'validation' => $_SESSION['etapes_validation'][$examiner][2] ?? 'Non évalué'
        ];
        
        // Étape 3 - Semestre
        $semestre = $this->etudiant->getSemestreActuel($examiner);
        $resume['semestre'] = [
            'semestre' => $semestre ? $semestre['lib_semestre'] : 'Non renseigné',
            'moyenne' => number_format($notes['moyenne'] ?? 0, 2) . '/20',
            'unites' => ($notes['unites_validees'] ?? 0) . '/' . ($notes['total_unites'] ?? 0) . ' crédits du Master 2 validés',
            'validation' => $_SESSION['etapes_validation'][$examiner][3] ?? 'Non évalué'
        ];
        
        return $resume;
    }

    // Méthode pour déterminer la décision finale
    private function determinerDecision($resume) {
        $rejets = 0;
        foreach ($resume as $etape) {
            if ($etape['validation'] === 'rejeté') {
                $rejets++;
            }
        }
        
        return $rejets > 0 ? 'Rejetée' : 'Validée';
    }

    // Méthode pour envoyer l'email de résultat
    private function envoyerEmailResultat($examiner, $resume, $decision) {
        // Récupérer les informations de l'étudiant
        $etudiant = $this->etudiant->getEtudiantByNumEtu($examiner);
        if (!$etudiant || empty($etudiant['email_etu'])) {
            error_log("Email non trouvé pour l'étudiant: $examiner");
            return;
        }
        
        $studentName = $etudiant['prenom_etu'] . ' ' . $etudiant['nom_etu'];
        
        // Utiliser le service EmailService avec PHPMailer
        return $this->emailService->sendResultEmail($etudiant['email_etu'], $studentName, $resume, $decision);
    }

    // Nouvelle méthode pour récupérer le résumé de candidature
    public function afficherResumeCandidature($num_etu) {
        return $this->etudiant->getResumeCandidature($num_etu);
    }

    public function getLastCandidatureByNumEtu($num_etu) {
        $sql = "SELECT * FROM candidature_soutenance WHERE num_etu = ? ORDER BY date_candidature DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   



 

   
}