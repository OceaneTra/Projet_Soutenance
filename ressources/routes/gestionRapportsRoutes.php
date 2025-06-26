<?php

if ($_GET['page'] === 'gestion_rapports') {
    require_once __DIR__ . '/../../app/controllers/GestionRapportController.php';
    $controller = new GestionRapportController();

    // Gestion du POST pour le dépôt de rapport
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deposer_rapport') {
        $controller->traiterCreationRapport();
        exit;
    }

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'creer_rapport':
                $controller->creerRapport();
                break;
            case 'suivi_rapport':
                $controller->suiviRapport();
                break;
            case 'commentaire_rapport':
                $controller->commentaireRapport();
                break;
            case 'delete_rapport':
                $controller->deleteRapportAjax();
                break;
            case 'get_rapport':
                $controller->getRapportAjax();
                break;
            case 'exporter_rapports':
                $controller->exporterRapports();
                break;
            default:
                // Action non reconnue, rediriger vers le dashboard
                header('Location: ?page=gestion_rapports');
                exit;
        }
    } else {
        // Pas d'action spécifiée, afficher le dashboard
        $controller->index();
    }
}
?>