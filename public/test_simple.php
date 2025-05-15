<?php
// test_minimal.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "TEST: Start<br>";

// Test direct de la vue avec des données
$listeEtudiant = $listeEtudiants ?? [];

echo "TEST: Including view with " . count($listeEtudiant) . " students<br>";

include __DIR__ . '/../ressources/views/admin/gestion_etudiants_content.php';

echo "TEST: Done<br>";
?>