<?php
// Configuration de la base de données
define('DB_HOST', 'db');  // Nom du service Docker
define('DB_NAME', 'soutenance_manager');
define('DB_USER', 'root');
define('DB_PASS', 'password'); // À adapter selon votre configuration

// Vous pouvez ajouter d'autres constantes ou fonctions ici si nécessaire
// Par exemple, une fonction pour établir une connexion PDO

function connectDB() {
    try {
        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        error_log("Erreur de connexion à la base de données: " . $e->getMessage());
        return null;
    }
}