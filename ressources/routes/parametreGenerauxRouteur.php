<?php
if ($_GET['page'] === 'parametres_generaux') {
    require_once __DIR__ . '/../../app/controllers/ParametreController.php';
    $controller = new ParametreController();

    if (isset($_GET['action']) && $_GET['action'] === 'annees_academiques') {
        $controller->gestionAnnees(); // ici tu peux gérer POST, getAll, etc...
    }

    if (isset($_GET['action']) && $_GET['action'] === 'grades') {
        $controller->gestionGrade();//ici on gere POST, getAll, etc...
    }
}

