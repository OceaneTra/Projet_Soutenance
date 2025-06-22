<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/Enseignant.php";
require_once __DIR__ . "/../models/Cours.php";
require_once __DIR__ . "/../models/Evaluation.php";
require_once __DIR__ . "/../models/Etudiant.php";
require_once __DIR__ . "/../models/RapportEtudiant.php";

/**
 * Contrôleur du tableau de bord enseignant
 * 
 * Ce contrôleur gère l'affichage des statistiques et des données du tableau de bord enseignant :
 * - Statistiques des cours enseignés
 * - Statistiques des évaluations
 * - Statistiques des étudiants encadrés
 * - Activités récentes
 * - Calendrier et échéances
 */
class DashboardEnseignantController
{
    /** @var Enseignant */
    private $enseignant;

    /** @var Cours */
    private $cours;

    /** @var Evaluation */
    private $evaluation;

    /** @var Etudiant */
    private $etudiant;

    /** @var RapportEtudiant */
    private $rapport;

    /** @var string */
    private $baseViewPath;

    /**
     * Constructeur du contrôleur
     * Initialise les modèles et les chemins nécessaires
     */
    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/';
        $this->enseignant = new Enseignant(Database::getConnection());
        $this->cours = new Cours(Database::getConnection());
        $this->evaluation = new Evaluation(Database::getConnection());
        $this->etudiant = new Etudiant(Database::getConnection());
        $this->rapport = new RapportEtudiant(Database::getConnection());
    }

    /**
     * Point d'entrée principal du contrôleur
     * Affiche le tableau de bord enseignant avec toutes les statistiques
     */
    public function index()
    {
        // Récupération des statistiques globales
        $this->getGlobalStats();
        
        // Récupération des statistiques détaillées
        $this->getDetailedStats();
        
        // Récupération des activités récentes
        $this->getRecentActivities();
        
        // Récupération du calendrier
        $this->getCalendarData();
        
        // Récupération des cours de l'enseignant
        $this->getTeacherCourses();
        
        // Affichage de la vue
        $this->displayView();
    }

    /**
     * Récupère les statistiques globales
     */
    private function getGlobalStats()
    {
        // ID de l'enseignant connecté (à adapter selon votre système d'authentification)
        $enseignantId = $this->getCurrentTeacherId();
        
        // Statistiques des cours enseignés
        $GLOBALS['cours_enseignes'] = $this->cours->getCoursByEnseignant($enseignantId) ?? [];
        $GLOBALS['total_cours'] = count($GLOBALS['cours_enseignes']);

        // Statistiques des évaluations
        $GLOBALS['evaluations_a_faire'] = $this->evaluation->getEvaluationsEnAttente($enseignantId) ?? [];
        $GLOBALS['total_evaluations_a_faire'] = count($GLOBALS['evaluations_a_faire']);
        
        $GLOBALS['evaluations_terminees'] = $this->evaluation->getEvaluationsTerminees($enseignantId) ?? [];
        $GLOBALS['total_evaluations_terminees'] = count($GLOBALS['evaluations_terminees']);

        // Statistiques des étudiants encadrés (simulation pour l'instant)
        $GLOBALS['etudiants_encadres'] = $this->getEtudiantsEncadres($enseignantId);
        $GLOBALS['total_etudiants_encadres'] = count($GLOBALS['etudiants_encadres']);

        // Statistiques des rapports
        $GLOBALS['rapports_a_evaluer'] = $this->getRapportsEnAttente($enseignantId);
        $GLOBALS['total_rapports_a_evaluer'] = count($GLOBALS['rapports_a_evaluer']);
    }

    /**
     * Récupère les étudiants encadrés par l'enseignant
     */
    private function getEtudiantsEncadres($enseignantId)
    {
        // Simulation - à adapter selon votre structure de base de données
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    e.num_etu,
                    e.nom_etu,
                    e.prenom_etu,
                    e.email_etu,
                    e.niveau_etude
                FROM etudiants e
                JOIN encadrement enc ON e.num_etu = enc.num_etu
                WHERE enc.id_enseignant = ?
                ORDER BY e.nom_etu, e.prenom_etu
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération étudiants encadrés: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les rapports en attente d'évaluation
     */
    private function getRapportsEnAttente($enseignantId)
    {
        // Simulation - à adapter selon votre structure de base de données
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    r.id_rapport,
                    r.nom_rapport,
                    r.theme_rapport,
                    r.date_rapport,
                    e.nom_etu,
                    e.prenom_etu,
                    c.nom_cours
                FROM rapport_etudiants r
                JOIN etudiants e ON r.num_etu = e.num_etu
                LEFT JOIN cours c ON r.id_cours = c.id_cours
                WHERE r.statut_rapport = 'en_cours'
                AND c.id_enseignant = ?
                ORDER BY r.date_rapport DESC
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération rapports en attente: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les statistiques détaillées
     */
    private function getDetailedStats()
    {
        $totalEvaluations = ($GLOBALS['total_evaluations_a_faire'] ?? 0) + ($GLOBALS['total_evaluations_terminees'] ?? 0);
        
        // Calcul du pourcentage de progression
        $GLOBALS['progression_evaluations'] = $totalEvaluations > 0 ? 
            round((($GLOBALS['total_evaluations_terminees'] ?? 0) / $totalEvaluations) * 100, 1) : 0;

        // Statistiques détaillées
        $GLOBALS['stats_detaillees'] = [
            'cours' => [
                'total' => $GLOBALS['total_cours'] ?? 0,
                'cours_list' => $GLOBALS['cours_enseignes'] ?? []
            ],
            'evaluations' => [
                'a_faire' => $GLOBALS['total_evaluations_a_faire'] ?? 0,
                'terminees' => $GLOBALS['total_evaluations_terminees'] ?? 0,
                'progression' => $GLOBALS['progression_evaluations'] ?? 0
            ],
            'etudiants' => [
                'encadres' => $GLOBALS['total_etudiants_encadres'] ?? 0,
                'liste' => $GLOBALS['etudiants_encadres'] ?? []
            ],
            'rapports' => [
                'a_evaluer' => $GLOBALS['total_rapports_a_evaluer'] ?? 0
            ]
        ];
    }

    /**
     * Récupère les activités récentes
     */
    private function getRecentActivities()
    {
        $enseignantId = $this->getCurrentTeacherId();
        
        // Récupération des activités récentes
        $GLOBALS['activites_recentes'] = [
            // Rapports soumis récemment
            ...array_map(function($rapport) {
                return [
                    'type' => 'rapport',
                    'description' => "Nouveau rapport soumis par " . $rapport['nom_etu'] . " " . $rapport['prenom_etu'] . " (" . ($rapport['nom_cours'] ?? 'Cours non spécifié') . ")",
                    'date' => date('d/m/Y', strtotime($rapport['date_rapport'])),
                    'action' => 'Évaluer',
                    'id' => $rapport['id_rapport']
                ];
            }, array_slice($GLOBALS['rapports_a_evaluer'] ?? [], 0, 3)),
            
            // Évaluations en attente
            ...array_map(function($eval) {
                return [
                    'type' => 'evaluation',
                    'description' => ($eval['devoirs_soumis'] ?? 0) . " nouveaux devoirs soumis pour " . $eval['nom_cours'],
                    'date' => date('d/m/Y', strtotime($eval['date_limite'])),
                    'action' => 'Voir devoirs',
                    'id' => $eval['id_cours']
                ];
            }, array_slice($GLOBALS['evaluations_a_faire'] ?? [], 0, 2))
        ];
    }

    /**
     * Récupère les données du calendrier
     */
    private function getCalendarData()
    {
        $enseignantId = $this->getCurrentTeacherId();
        
        // Échéances d'évaluation
        $echeances = $this->evaluation->getEcheancesEvaluation($enseignantId) ?? [];
        $echeancesFormatted = array_map(function($echeance) {
            return [
                'type' => 'echeance',
                'titre' => 'Date limite d\'évaluation - ' . $echeance['nom_cours'],
                'date' => $echeance['date_limite'],
                'couleur' => 'orange'
            ];
        }, $echeances);
        
        // Soutenances programmées
        $soutenances = $this->getSoutenancesProgrammees($enseignantId);
        
        // Réunions
        $reunions = $this->getReunionsProgrammees($enseignantId);
        
        $GLOBALS['calendrier'] = array_merge($echeancesFormatted, $soutenances, $reunions);
        
        // Tri par date
        usort($GLOBALS['calendrier'], function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
    }

    /**
     * Récupère les cours de l'enseignant
     */
    private function getTeacherCourses()
    {
        $enseignantId = $this->getCurrentTeacherId();
        
        $GLOBALS['mes_cours'] = array_map(function($cours) {
            return [
                'id' => $cours['id_cours'],
                'nom' => $cours['nom_cours'],
                'niveau' => $cours['niveau'],
                'nombre_etudiants' => $cours['nombre_etudiants'] ?? 0
            ];
        }, $GLOBALS['cours_enseignes'] ?? []);
    }

    /**
     * Récupère les soutenances programmées
     */
    private function getSoutenancesProgrammees($enseignantId)
    {
        // Simulation de données de soutenances
        return [
            [
                'type' => 'soutenance',
                'titre' => 'Soutenance de stage - Projet Alpha',
                'date' => '2024-05-25',
                'couleur' => 'blue'
            ]
        ];
    }

    /**
     * Récupère les réunions programmées
     */
    private function getReunionsProgrammees($enseignantId)
    {
        // Simulation de données de réunions
        return [
            [
                'type' => 'reunion',
                'titre' => 'Réunion d\'équipe pédagogique',
                'date' => '2024-05-20',
                'couleur' => 'green'
            ]
        ];
    }

    /**
     * Récupère l'ID de l'enseignant connecté
     * À adapter selon votre système d'authentification
     */
    private function getCurrentTeacherId()
    {
        // Simulation - à remplacer par votre logique d'authentification
        return $_SESSION['id_utilisateur'] ?? 1;
    }

    /**
     * Affiche la vue du dashboard
     */
    private function displayView()
    {
        include $this->baseViewPath . 'dashboard_enseignant_content.php';
    }

    /**
     * API pour récupérer les statistiques en JSON
     */
    public function getStats()
    {
        $this->getGlobalStats();
        $this->getDetailedStats();
        
        header('Content-Type: application/json');
        echo json_encode([
            'stats' => $GLOBALS['stats_detaillees'] ?? [],
            'activites' => $GLOBALS['activites_recentes'] ?? [],
            'calendrier' => $GLOBALS['calendrier'] ?? [],
            'cours' => $GLOBALS['mes_cours'] ?? []
        ]);
    }
} 