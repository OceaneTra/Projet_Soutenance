<?php
if (isset($_GET['page']) && $_GET['page'] === 'candidature_soutenance') {
    require_once __DIR__ . '/../../app/controllers/CandidatureSoutenanceController.php';
    $controller = new CandidatureSoutenanceController();

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'demande_candidature':
                $controller->demande_candidature();
                break;
            case 'compte_rendu_etudiant':
                $controller->compteRenduRapport();
                break;
            default:
                '';
        }
    }

}