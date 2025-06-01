<?php
if ($_GET['page'] === 'gestion_etudiants') {
    require_once __DIR__ . '/../../app/controllers/GestionEtudiantController.php';
    $controller = new GestionEtudiantController();

    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'ajouter_etudiants':
                $controller->ajouterEtudiant();
                break;
            case 'inscrire_etudiants':
                $controller->inscrireEtudiant();
                break;
            
            default:
                '';
        }
    }

}