<?php
require_once __DIR__ . '/../models/Reclamation.php';
require_once __DIR__ . '/../config/database.php';

class GestionReclamationsScolariteController {
    private $reclamationModel;

    public function __construct() {
        $this->reclamationModel = new Reclamation();
    }

    public function index() {
        // Récupérer toutes les réclamations avec infos étudiant
        $allReclamations = $this->reclamationModel->getAllReclamationsWithEtudiant();

        // Séparer en cours/attente et traitées/clôturées
        $reclamationsEnCours = [];
        $reclamationsTraitees = [];
        foreach ($allReclamations as $rec) {
            if ($rec->statut_reclamation === 'En attente' || $rec->statut_reclamation === 'En cours') {
                $reclamationsEnCours[] = $rec;
            } else {
                $reclamationsTraitees[] = $rec;
            }
        }

        // Passer aux vues
        $GLOBALS['reclamationsEnCours'] = $reclamationsEnCours;
        $GLOBALS['reclamationsTraitees'] = $reclamationsTraitees;

    }

    public function changerStatut() {
        if (isset($_GET['id']) && isset($_POST['nouveau_statut'])) {
            $id = (int)$_GET['id'];
            $nouveauStatut = $_POST['nouveau_statut'];
            $this->reclamationModel->updateStatut($id, $nouveauStatut);
        }
        header('Location: ?page=gestion_reclamations_scolarite');
        exit;
    }
}