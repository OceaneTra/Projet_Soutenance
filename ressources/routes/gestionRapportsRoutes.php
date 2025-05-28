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
            default:
                '';
        }
    }

}