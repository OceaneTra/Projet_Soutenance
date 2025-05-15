<?php
echo "DEBUG ROUTING: Start<br>";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/GestionEtudiantController.php';

echo "DEBUG ROUTING: Checking page parameter<br>";
echo "GET parameters: " . print_r($_GET, true) . "<br>";

if (isset($_GET['page']) && $_GET['page'] === 'gestion_etudiants') {
    echo "DEBUG ROUTING: Page is gestion_etudiants<br>";

    $controller = new GestionEtudiantController();
    echo "DEBUG ROUTING: Controller created<br>";

    if (isset($_GET['action']) && $_GET['action'] === 'export') {
        echo "DEBUG ROUTING: Export action<br>";
        $controller->exporterEtudiants();
    } else {
        echo "DEBUG ROUTING: Calling index()<br>";
        $controller->index();
        echo "DEBUG ROUTING: After index()<br>";
    }
} else {
    echo "DEBUG ROUTING: Page not gestion_etudiants or not set<br>";
}
?>