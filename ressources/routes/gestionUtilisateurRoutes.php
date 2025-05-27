<?php


require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/GestionUtilisateurController.php';


if (isset($_GET['page']) && $_GET['page'] === 'gestion_utilisateurs') {

    $controller = new GestionUtilisateurController();
    
    $controller->index();
        
    
}



?>