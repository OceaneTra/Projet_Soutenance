<?php
// test_controller_direct.php
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/GestionEtudiantController.php';

echo "TEST CONTROLLER: Starting<br>";

// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    echo "TEST CONTROLLER: Creating controller<br>";
    $controller = new GestionEtudiantController();

    echo "TEST CONTROLLER: Controller created<br>";
    echo "TEST CONTROLLER: Calling index()<br>";

    $controller->index();

    echo "TEST CONTROLLER: index() completed<br>";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>