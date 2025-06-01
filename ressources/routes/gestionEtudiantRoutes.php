<?php
if ($_GET['page'] === 'gestion_etudiants') {
    require_once __DIR__ . '/../../app/controllers/GestionEtudiantController.php';
    $controller = new GestionEtudiantController();

    $controller->index();

}