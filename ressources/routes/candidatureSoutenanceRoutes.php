<?php
if ($_GET['page'] === 'candidature_soutenance') {
    require_once __DIR__ . '/../../app/controllers/CandidatureSoutenanceController.php';
    $controller = new CandidatureSoutenanceController();

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'simulateur_eligibilite':
                $controller->simulateur();
                break;
            case 'compte_rendu_etudiant':
                $controller->compteRenduRapport();
                break;
            default:
                '';
        }
    }

}