<?php
if ($_GET['page'] === 'gestion_reclamations') {
    require_once __DIR__ . '/../../app/controllers/GestionReclamationsController.php';
    $controller = new GestionReclamationsController();

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'soumettre_reclamation':
                $controller->soumettreReclamations();
                break;
            case 'suivi_reclamation':
                $controller->suiviReclamations();
                break;
            case 'historique_reclamation':
                $controller->historiqueReclamations();
                break;
            default:
                '';
        }
    }

}