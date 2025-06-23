<?php
if (isset($_GET['page']) && $_GET['page'] === 'verification_candidatures_soutenance') {

    require_once __DIR__ . '/../../app/controllers/VerificationRapportsController.php';
    $controller = new VerificationRapportsController();
    
    $controller->index();
} 