<?php

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/RapportEtudiant.php';
class VerificationRapportsController {
    public function index() {

$rapportModel = new RapportEtudiant(Database::getConnection());
$rapports = $rapportModel->getAllRapports();
$nbRapports = count($rapports);
       
    }
} 