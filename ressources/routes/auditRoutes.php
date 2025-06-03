<?php
require_once __DIR__ . '/../../app/controllers/AuditController.php';
require_once __DIR__ . '/../../app/config/database.php';


// Route pour la page principale des logs d'audit
if (isset($_GET['page']) && $_GET['page'] === 'piste_audit') {
    $auditController = new AuditController($db);
    $auditController->index();
    exit;
}