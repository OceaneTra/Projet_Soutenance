<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/Etudiant.php";
require_once __DIR__ . "/../models/Scolarite.php";

/**
 * Contrôleur du tableau de bord de la scolarité
 * 
 * Ce contrôleur gère l'affichage des statistiques et des données du tableau de bord de la scolarité :
 * - Statistiques des étudiants
 * - Nouvelles inscriptions
 * - Notes à valider
 * - Paiements en attente
 * - Activités récentes
 */
class DashboardScolariteController
{
    /** @var Etudiant */
    private $etudiant;

    /** @var Scolarite */
    private $scolarite;

    /** @var string */
    private $baseViewPath;

    /**
     * Constructeur du contrôleur
     * Initialise les modèles et les chemins nécessaires
     */
    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/';
        $this->etudiant = new Etudiant(Database::getConnection());
        $this->scolarite = new Scolarite(Database::getConnection());
    }

    /**
     * Récupère les données pour le tableau de bord de la scolarité
     * @return array Les données du tableau de bord
     */
    public function getDashboardData()
    {
        $stats = [
            'etudiants' => 0,
            'nouvelles_inscriptions' => 0,
            'notes_a_valider' => 0,
            'paiements_en_attente' => 0,
            'montant_total_paiements' => 0
        ];

        try {
            // Nombre total d'étudiants
            $stats['etudiants'] = count($this->etudiant->getAllEtudiants());

            // Nouvelles inscriptions (dernière semaine)
            $query = "SELECT COUNT(*) as total FROM inscriptions WHERE date_inscription >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
            $stmt = Database::getConnection()->query($query);
            $stats['nouvelles_inscriptions'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Notes à valider
            $query = "SELECT COUNT(*) as total FROM notes WHERE statut = 'en_attente'";
            $stmt = Database::getConnection()->query($query);
            $stats['notes_a_valider'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Paiements en attente
            $query = "SELECT COUNT(*) as total, SUM(montant) as montant_total FROM paiements WHERE statut = 'en_attente'";
            $stmt = Database::getConnection()->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stats['paiements_en_attente'] = $result['total'];
            $stats['montant_total_paiements'] = $result['montant_total'] ?? 0;

            // Activités récentes
            $query = "SELECT * FROM activites ORDER BY date_activite DESC LIMIT 3";
            $stmt = Database::getConnection()->query($query);
            $activites = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'stats' => $stats,
                'activites' => $activites
            ];

        } catch(PDOException $e) {
            error_log("Erreur de base de données : " . $e->getMessage());
            return [
                'stats' => $stats,
                'activites' => [],
                'error' => "Une erreur est survenue lors de la récupération des données"
            ];
        }
    }
}