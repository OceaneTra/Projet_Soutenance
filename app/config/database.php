<?php
// Paramètres de connexion à la base de données
$db_host = 'db';         // Nom du service Docker MySQL
$db_name = 'validmaster'; // Nom de la base de données
$db_user = 'user';       // Nom d'utilisateur (à adapter selon votre docker-compose.yml)
$db_pass = 'password';   // Mot de passe (à adapter selon votre docker-compose.yml)

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}