<?php

if ($_GET['page'] === 'gestion_rapports') {
    require_once __DIR__ . '/../../app/controllers/GestionRapportController.php';
    $controller = new GestionRapportController();

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'creer_rapport':
                $controller->creerRapport();
                break;
            case 'suivi_rapport':
                $controller->suiviRapport();
                break;
            case 'compte_rendu_rapport':
                $controller->compteRenduRapport();
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