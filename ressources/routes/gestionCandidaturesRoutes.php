<?php

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/GestionCandidaturesController.php';

$controller = new GestionCandidaturesController();


$controller->index();