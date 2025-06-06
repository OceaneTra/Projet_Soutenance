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
} 