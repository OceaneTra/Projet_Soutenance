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
        $enseignantId = $this->getCurrentTeacherId();
        
        if (!$enseignantId) {
            $GLOBALS['messageErreur'] = "Enseignant non connecté ou ID invalide.";
            return;
        }

        // Paramètres de pagination et filtres
        $currentPage = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit = 10;
        $offset = ($currentPage - 1) * $limit;
        
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $filterEcue = isset($_GET['filter_ecue']) ? (int)$_GET['filter_ecue'] : 0;
        $filterUe = isset($_GET['filter_ue']) ? (int)$_GET['filter_ue'] : 0;

        // Récupérer les ECUE et UE de l'enseignant pour les filtres
        $ecuesEnseignant = $this->ecue->getEcuesByEnseignant($enseignantId);
        $uesEnseignant = $this->ue->getUesByEnseignant($enseignantId);

        // Debug: Afficher les informations de débogage
        error_log("DEBUG: Enseignant ID: " . $enseignantId);
        error_log("DEBUG: Nombre d'ECUEs trouvés: " . count($ecuesEnseignant));
        error_log("DEBUG: Nombre d'UEs trouvées: " . count($uesEnseignant));

        // Récupérer les étudiants encadrés avec pagination et filtres
        $etudiants = $this->ecue->getEtudiantsEncadres($enseignantId, $search, $filterEcue, $filterUe, $limit, $offset);
        
        // Debug: Afficher le nombre d'étudiants trouvés
        error_log("DEBUG: Nombre d'étudiants trouvés: " . count($etudiants));
        
        // Si aucun étudiant trouvé avec la première méthode, essayer la méthode alternative
        if (empty($etudiants)) {
            error_log("DEBUG: Aucun étudiant trouvé avec la première méthode, essai de la méthode alternative");
            $etudiants = $this->ecue->getEtudiantsEncadresSimple($enseignantId, $search, $filterEcue, $filterUe, $limit, $offset);
            error_log("DEBUG: Nombre d'étudiants trouvés avec la méthode alternative: " . count($etudiants));
        }
        
        // Si toujours aucun étudiant, utiliser la méthode de test
        if (empty($etudiants)) {
            error_log("DEBUG: Aucun étudiant trouvé avec la méthode alternative, essai de la méthode de test");
            $etudiants = $this->ecue->getAllEtudiantsForTest($enseignantId, $search, $limit, $offset);
            error_log("DEBUG: Nombre d'étudiants trouvés avec la méthode de test: " . count($etudiants));
        }
        
        // Compter le nombre total d'étudiants pour la pagination
        $totalEtudiants = $this->ecue->countEtudiantsEncadres($enseignantId, $search, $filterEcue, $filterUe);
        
        // Si le comptage retourne 0, essayer de compter avec la méthode simple
        if ($totalEtudiants == 0) {
            // Compter avec une approche simplifiée
            $totalEtudiants = count($this->ecue->getEtudiantsEncadresSimple($enseignantId, $search, $filterEcue, $filterUe, 1000, 0));
        }
        
        // Debug: Afficher le total d'étudiants
        error_log("DEBUG: Total d'étudiants: " . $totalEtudiants);
        
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

    /**
     * Récupère l'ID de l'enseignant connecté
     */
    private function getCurrentTeacherId()
    {
        if (!isset($_SESSION['login_utilisateur'])) {
            return null;
        }

        $enseignant = $this->enseignant->getEnseignantByLogin($_SESSION['login_utilisateur']);
        return $enseignant ? $enseignant->id_enseignant : null;
    }

    /**
     * Méthode de test pour vérifier les données
     */
    public function test()
    {
        // Test 1: Vérifier si on peut récupérer des enseignants
        $enseignants = $this->enseignant->getAllEnseignants();
        error_log("TEST: Nombre total d'enseignants: " . count($enseignants));
        
        // Test 2: Vérifier si on peut récupérer des étudiants
        $etudiants = $this->etudiant->getAllEtudiants();
        error_log("TEST: Nombre total d'étudiants: " . count($etudiants));
        
        // Test 3: Vérifier si on peut récupérer des ECUEs
        $ecues = $this->ecue->getAllEcues();
        error_log("TEST: Nombre total d'ECUEs: " . count($ecues));
        
        // Test 4: Vérifier si on peut récupérer des UEs
        $ues = $this->ue->getAllUes();
        error_log("TEST: Nombre total d'UEs: " . count($ues));
        
        // Test 5: Vérifier les ECUEs avec enseignant assigné
        $ecuesAvecEnseignant = array_filter($ecues, function($ecue) {
            return !empty($ecue->id_enseignant);
        });
        error_log("TEST: Nombre d'ECUEs avec enseignant assigné: " . count($ecuesAvecEnseignant));
        
        if (!empty($ecuesAvecEnseignant)) {
            $premierEcue = reset($ecuesAvecEnseignant);
            error_log("TEST: Premier ECUE avec enseignant - ID: " . $premierEcue->id_ecue . ", Enseignant: " . $premierEcue->id_enseignant);
        }
    }
} 