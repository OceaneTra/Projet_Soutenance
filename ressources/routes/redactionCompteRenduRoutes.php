<?php

require_once __DIR__ . '/../../app/controllers/RedactionCompteRenduController.php';

if (isset($_GET['page']) && $_GET['page'] === 'redaction_compte_rendu') {
    $controller = new RedactionCompteRenduController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->enregistrer();
    } else {
        $controller->index();
    }
} 