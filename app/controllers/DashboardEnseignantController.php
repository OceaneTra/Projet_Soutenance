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
        
        // Récupération des statistiques avancées pour les graphiques
        $this->getAdvancedStats();
        
       
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

    /**
     * Récupère les statistiques avancées pour les graphiques
     */
    private function getAdvancedStats()
    {
        $enseignantId = $this->getCurrentTeacherId();
        
        // Statistiques des évaluations par mois
        $GLOBALS['evaluations_par_mois'] = $this->getEvaluationsParMois($enseignantId);
        
        // Statistiques des notes moyennes par cours
        $GLOBALS['notes_moyennes_cours'] = $this->getNotesMoyennesParCours($enseignantId);
        
        // Statistiques des types d'évaluations
        $GLOBALS['types_evaluations'] = $this->getTypesEvaluations($enseignantId);
        
        // Statistiques des étudiants par niveau
        $GLOBALS['etudiants_par_niveau'] = $this->getEtudiantsParNiveau($enseignantId);
        
        // Statistiques de performance des cours
        $GLOBALS['performance_cours'] = $this->getPerformanceCours($enseignantId);
        
        // Statistiques des échéances
        $GLOBALS['echeances_prochaines'] = $this->getEcheancesProchaines($enseignantId);
        
        // Statistiques des rapports
        $GLOBALS['stats_rapports'] = $this->getStatsRapports($enseignantId);
        
        // Distribution des notes
        $GLOBALS['distribution_notes'] = $this->getDistributionNotes($enseignantId);
    }

    /**
     * Récupère les évaluations par mois pour l'année en cours
     */
    private function getEvaluationsParMois($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    MONTH(e.date_creation) as mois,
                    COUNT(*) as nombre_evaluations,
                    COUNT(CASE WHEN e.statut = 'terminee' THEN 1 END) as evaluations_terminees,
                    COUNT(CASE WHEN e.statut = 'en_attente' THEN 1 END) as evaluations_en_attente
                FROM evaluations e
                JOIN cours c ON e.id_cours = c.id_cours
                WHERE c.id_enseignant = ?
                AND YEAR(e.date_creation) = YEAR(CURDATE())
                GROUP BY MONTH(e.date_creation)
                ORDER BY mois
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération évaluations par mois: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les notes moyennes par cours
     */
    private function getNotesMoyennesParCours($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    c.nom_cours,
                    c.niveau,
                    COUNT(n.id) as nombre_notes,
                    AVG(n.moyenne) as moyenne_generale,
                    MIN(n.moyenne) as note_min,
                    MAX(n.moyenne) as note_max
                FROM cours c
                LEFT JOIN evaluations e ON c.id_cours = e.id_cours
                LEFT JOIN devoirs d ON e.id_evaluation = d.id_evaluation
                LEFT JOIN notes n ON d.id_devoir = n.id_devoir
                WHERE c.id_enseignant = ?
                AND n.moyenne IS NOT NULL
                GROUP BY c.id_cours, c.nom_cours, c.niveau
                ORDER BY moyenne_generale DESC
                LIMIT 10
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération notes moyennes: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les types d'évaluations
     */
    private function getTypesEvaluations($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    e.type_evaluation,
                    COUNT(*) as nombre,
                    COUNT(CASE WHEN e.statut = 'terminee' THEN 1 END) as terminees,
                    COUNT(CASE WHEN e.statut = 'en_attente' THEN 1 END) as en_attente
                FROM evaluations e
                JOIN cours c ON e.id_cours = c.id_cours
                WHERE c.id_enseignant = ?
                GROUP BY e.type_evaluation
                ORDER BY nombre DESC
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération types évaluations: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les étudiants par niveau
     */
    private function getEtudiantsParNiveau($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    c.niveau,
                    COUNT(DISTINCT d.num_etu) as nombre_etudiants
                FROM cours c
                LEFT JOIN devoirs d ON c.id_cours = d.id_cours
                WHERE c.id_enseignant = ?
                GROUP BY c.niveau
                ORDER BY nombre_etudiants DESC
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération étudiants par niveau: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère la performance des cours
     */
    private function getPerformanceCours($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    c.nom_cours,
                    c.niveau,
                    COUNT(DISTINCT d.num_etu) as nombre_etudiants,
                    AVG(n.moyenne) as moyenne_cours,
                    COUNT(CASE WHEN n.moyenne >= 10 THEN 1 END) as reussites,
                    COUNT(CASE WHEN n.moyenne < 10 THEN 1 END) as echecs
                FROM cours c
                LEFT JOIN evaluations e ON c.id_cours = e.id_cours
                LEFT JOIN devoirs d ON e.id_evaluation = d.id_evaluation
                LEFT JOIN notes n ON d.id_devoir = n.id_devoir
                WHERE c.id_enseignant = ?
                AND n.moyenne IS NOT NULL
                GROUP BY c.id_cours, c.nom_cours, c.niveau
                ORDER BY moyenne_cours DESC
                LIMIT 8
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération performance cours: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les échéances prochaines
     */
    private function getEcheancesProchaines($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    e.id_evaluation,
                    c.nom_cours,
                    e.type_evaluation,
                    e.date_limite,
                    DATEDIFF(e.date_limite, CURDATE()) as jours_restants,
                    COUNT(d.id_devoir) as devoirs_soumis,
                    e.nombre_devoirs
                FROM evaluations e
                JOIN cours c ON e.id_cours = c.id_cours
                LEFT JOIN devoirs d ON e.id_evaluation = d.id_evaluation
                WHERE c.id_enseignant = ?
                AND e.statut = 'en_attente'
                AND e.date_limite >= CURDATE()
                GROUP BY e.id_evaluation, c.nom_cours, e.type_evaluation, e.date_limite, e.nombre_devoirs
                ORDER BY e.date_limite ASC
                LIMIT 10
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération échéances: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Récupère les statistiques des rapports
     */
    private function getStatsRapports($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    COUNT(*) as total_rapports,
                    COUNT(CASE WHEN r.statut_rapport = 'en_attente' THEN 1 END) as rapports_en_attente,
                    COUNT(CASE WHEN r.statut_rapport = 'en_cours' THEN 1 END) as rapports_en_cours,
                    COUNT(CASE WHEN r.statut_rapport = 'valide' THEN 1 END) as rapports_valides,
                    COUNT(CASE WHEN r.statut_rapport = 'rejete' THEN 1 END) as rapports_rejetes,
                    AVG(CASE WHEN ev.note IS NOT NULL THEN ev.note END) as note_moyenne
                FROM rapport_etudiants r
                LEFT JOIN evaluations_rapports ev ON r.id_rapport = ev.id_rapport
                WHERE r.id_enseignant_encadrant = ?
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération stats rapports: " . $e->getMessage());
            return [
                'total_rapports' => 0,
                'rapports_en_attente' => 0,
                'rapports_en_cours' => 0,
                'rapports_valides' => 0,
                'rapports_rejetes' => 0,
                'note_moyenne' => 0
            ];
        }
    }

    /**
     * Récupère la distribution des notes
     */
    private function getDistributionNotes($enseignantId)
    {
        try {
            $stmt = Database::getConnection()->prepare("
                SELECT 
                    CASE 
                        WHEN n.moyenne BETWEEN 0 AND 5 THEN '0-5'
                        WHEN n.moyenne BETWEEN 6 AND 10 THEN '6-10'
                        WHEN n.moyenne BETWEEN 11 AND 15 THEN '11-15'
                        WHEN n.moyenne BETWEEN 16 AND 20 THEN '16-20'
                    END as tranche_notes,
                    COUNT(*) as nombre_etudiants
                FROM notes n
                JOIN devoirs d ON n.id_devoir = d.id_devoir
                JOIN evaluations e ON d.id_evaluation = e.id_evaluation
                JOIN cours c ON e.id_cours = c.id_cours
                WHERE c.id_enseignant = ?
                AND n.moyenne IS NOT NULL
                GROUP BY 
                    CASE 
                        WHEN n.moyenne BETWEEN 0 AND 5 THEN '0-5'
                        WHEN n.moyenne BETWEEN 6 AND 10 THEN '6-10'
                        WHEN n.moyenne BETWEEN 11 AND 15 THEN '11-15'
                        WHEN n.moyenne BETWEEN 16 AND 20 THEN '16-20'
                    END
                ORDER BY tranche_notes
            ");
            $stmt->execute([$enseignantId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur récupération distribution notes: " . $e->getMessage());
            return [
                ['tranche_notes' => '0-5', 'nombre_etudiants' => 0],
                ['tranche_notes' => '6-10', 'nombre_etudiants' => 0],
                ['tranche_notes' => '11-15', 'nombre_etudiants' => 0],
                ['tranche_notes' => '16-20', 'nombre_etudiants' => 0]
            ];
        }
    }
} 