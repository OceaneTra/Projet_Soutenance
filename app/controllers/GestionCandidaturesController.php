<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/Scolarite.php';
require_once __DIR__ . '/../models/InfoStage.php';

class GestionCandidaturesController {
    private $db;
    private $etudiant;
    private $scolarite;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->etudiant = new Etudiant($this->db);
        $this->scolarite = new Scolarite($this->db);
    }

    public function index() {
        $GLOBALS['candidatures_soutenance'] = $this->etudiant->getAllCandidature();
       
    }

    public function verifierCandidature() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_etu'])) {
            $numEtu = $_POST['num_etu'];
            $resultats = $this->etudiant->verifierCandidature($numEtu);
            echo json_encode($resultats);
        }
    }

    public function traiterCandidature() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numEtu = $_POST['num_etu'];
            $decision = $_POST['decision'];
            $commentaire = $_POST['commentaire'] ?? null;

            $success = $this->etudiant->traiterCandidature($numEtu, $decision, $commentaire);
            
            if ($success) {
                // Ajouter l'action dans l'historique
                $action = $decision === 'validee' ? 'validation' : 'rejet';
                $this->etudiant->ajouterHistoriqueCandidature($numEtu, $action, $commentaire);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors du traitement de la candidature']);
            }
        }
    }

    public function getHistorique() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $historique = $this->etudiant->getHistoriqueCandidature();
            echo json_encode($historique);
        }
    }

    public function getHistoriqueEtudiant() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['num_etu'])) {
            $numEtu = $_GET['num_etu'];
            $historique = $this->etudiant->getHistoriqueCandidature($numEtu);
            echo json_encode($historique);
        }
    }

    // Ajout d'une méthode pour gérer la vérification par étape (AJAX)
    public function verifier_etape() {
        if (isset($_GET['num_etu']) && isset($_GET['etape'])) {
            $numEtu = $_GET['num_etu'];
            $etape = intval($_GET['etape']);
            header('Content-Type: application/json');
            switch ($etape) {
                case 1: // Inscription
                    // ... code existant pour l'inscription ...
                    echo json_encode([
                        'status' => 'Validé',
                        'date' => '',
                        'filiere' => ''
                    ]);
                    break;
                case 2: // Scolarité
                    // ... code existant pour la scolarité ...
                    echo json_encode([
                        'status' => 'Validé',
                        'montant' => '',
                        'dernierPaiement' => ''
                    ]);
                    break;
                case 3: // Stage
                    $stageModel = new InfoStage($this->db);
                    $stage = $stageModel->getStageInfo($numEtu);
                    if ($stage) {
                        echo json_encode([
                            'entreprise' => $stage['nom_entreprise'] ?? '',
                            'sujet' => $stage['sujet_stage'] ?? '',
                            'periode' => ($stage['date_debut_stage'] ?? '') . ' - ' . ($stage['date_fin_stage'] ?? ''),
                            'encadrant' => $stage['encadrant_entreprise'] ?? ''
                        ]);
                    } else {
                        echo json_encode([
                            'entreprise' => 'Non renseigné',
                            'sujet' => 'Non renseigné',
                            'periode' => 'Non renseigné',
                            'encadrant' => 'Non renseigné'
                        ]);
                    }
                    break;
                case 4: // Semestre
                    // ... code existant pour le semestre ...
                    echo json_encode([
                        'semestre' => '',
                        'moyenne' => '',
                        'unites' => ''
                    ]);
                    break;
            }
            exit;
        }
    }
} 