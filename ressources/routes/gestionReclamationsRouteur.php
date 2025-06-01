<?php
// Routeur pour la gestion des réclamations
// Chemin adapté à votre structure existante

require_once __DIR__ . '/../../app/controllers/GestionReclamationsController.php';

// Créer une instance du contrôleur
$controller = new GestionReclamationsController();

// Gérer les actions
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'soumettre_reclamation':
            $controller->soumettreReclamations();
            break;
        case 'suivi_reclamation':
            $controller->suiviReclamations();
            break;
        case 'historique_reclamation':
            $controller->historiqueReclamations();
            break;
        case 'traiter':
            $controller->traiterReclamation();
            break;
        case 'export':
            $controller->exporterReclamations();
            break;
        default:
            // Action non reconnue, rediriger vers la page principale
            header('Location: ?page=gestion_reclamations');
            exit;
    }
} else {
    // Aucune action spécifiée, afficher le dashboard
    $controller->index();
}
?>