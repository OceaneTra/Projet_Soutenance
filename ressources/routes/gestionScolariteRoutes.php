<?php

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/GestionScolariteController.php';

$controller = new GestionScolariteController(Database::getConnection());


$controller->index();