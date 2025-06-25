<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Enseignant.php';
require_once __DIR__ . '/../models/Ecue.php';
require_once __DIR__ . '/../models/Ue.php';
require_once __DIR__ . '/../models/Etudiant.php';

class ListeEtudiantsEnseignantController
{
    private $enseignant;
    private $ecue;
    private $ue;
    private $etudiant;
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->enseignant = new Enseignant($this->db);
        $this->ecue = new Ecue($this->db);
        $this->ue = new Ue($this->db);
        $this->etudiant = new Etudiant($this->db);
    }

    public function index()
    {
        // Récupérer l'ID de l'enseignant connecté (à adapter selon votre système d'authentification)
        $enseignant = $this->enseignant->getEnseignantByLogin($_SESSION['login_utilisateur']);

        $enseignantId = $enseignant->id_enseignant;

        if (!$enseignantId) {
            $GLOBALS['messageErreur'] = "Enseignant non connecté.";
            return;
        }

        // Paramètres de pagination (utiliser 'p' au lieu de 'page')
        $currentPage = isset($_GET['p']) ? (int) $_GET['p'] : 1;
        $limit = 10;
        $offset = ($currentPage - 1) * $limit;

        // Paramètres de recherche et filtrage
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterEcue = isset($_GET['filter_ecue']) ? (int) $_GET['filter_ecue'] : 0;
        $filterUe = isset($_GET['filter_ue']) ? (int) $_GET['filter_ue'] : 0;

        // Récupérer les ECUE et UE de l'enseignant pour les filtres
        $ecuesEnseignant = $this->ecue->getEcuesByEnseignant($enseignantId);
        $uesEnseignant = $this->ue->getUesByEnseignant($enseignantId);

        // Récupérer les étudiants encadrés avec pagination et filtres
        $etudiants = $this->ecue->getEtudiantsEncadres($enseignantId, $search, $filterEcue, $filterUe, $limit, $offset);
        
        // Compter le nombre total d'étudiants pour la pagination
        $totalEtudiants = $this->ecue->countEtudiantsEncadres($enseignantId, $search, $filterEcue, $filterUe);
        
        // Calculer la pagination
        $totalPages = ceil($totalEtudiants / $limit);
        
        // Calculer les pages de début et fin pour la pagination
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        
        // Passer les données à la vue via les variables globales
        $GLOBALS['etudiants'] = $etudiants;
        $GLOBALS['ecuesEnseignant'] = $ecuesEnseignant;
        $GLOBALS['uesEnseignant'] = $uesEnseignant;
        $GLOBALS['filtres'] = [
            'search' => $search,
            'filterEcue' => $filterEcue,
            'filterUe' => $filterUe
        ];
        $GLOBALS['pagination'] = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalEtudiants' => $totalEtudiants,
            'start' => $startPage,
            'end' => $endPage,
            'limit' => $limit
        ];
    }
} 