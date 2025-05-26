<?php


require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/DashboardController.php';

$controller = new DashboardController();

if (isset($_GET['page']) && ( $_GET['page'] === 'dashboard')) {

    $controller->index(); 
}




?>