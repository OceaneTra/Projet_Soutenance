<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/GestionUtilisateurController.php';


if (isset($_GET['page']) && $_GET['page'] === 'gestion_utilisateurs') {

    $controller = new GestionUtilisateurController();
    

    if (isset($_GET['action']) && $_GET['action'] === 'export') {
      
        $controller->exporterEtudiants();
    } else {
       
        $controller->index();
       
    }
}
?>