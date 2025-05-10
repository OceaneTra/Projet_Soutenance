<?php
if ($_GET['page'] === 'parametres_generaux') {
    require_once __DIR__ . '/../../app/controllers/ParametreController.php';
    $controller = new ParametreController();

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'annees_academiques':
                $controller->gestionAnnees();
                break;
            case 'grades':
                $controller->gestionGrade();
                break;
            case 'fonction_utilisateur':
                $controller->gestionFonctionUtilisateur();
                break;
            default:
                '';
        }
    }

}

