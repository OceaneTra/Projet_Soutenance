<?php
require_once __DIR__ . '/../models/AnneeAcademique.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Fonction.php';

class DashboardController
{
    private $pdo;
    private $anneeAcademique;
    private $grade;
    private $fonction;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->anneeAcademique = new AnneeAcademique($pdo);
        $this->grade = new Grade($pdo);
        $this->fonction = new Fonction($pdo);
    }

    // Méthode pour afficher le dashboard principal
    public function index()
    {
        include __DIR__ . '/../../ressources/views/admin/dashboard.php';
    }

    // Méthode pour afficher la page principale des paramètres généraux
    public function afficherParametresGeneraux()
    {
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/vue_gparamgen.php';
    }

    // === GESTION DES ANNÉES ACADÉMIQUES ===
    public function anneeAcademique()
    {
        // Récupérer les messages de session
        $message = $_SESSION['success'] ?? '';
        $error = $_SESSION['error'] ?? '';

        // Vider les messages de session après les avoir récupérés
        unset($_SESSION['success'], $_SESSION['error']);

        // Récupérer toutes les années académiques
        $annees = $this->anneeAcademique->getAllAnneeAcademiques();

        // Debugging
        error_log("Controller - Données récupérées: " . json_encode($annees));

        // Définir explicitement la variable dans la portée globale
        $GLOBALS['annees'] = $annees;

        // Inclure la vue
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/annee_academique.php';
    }

}