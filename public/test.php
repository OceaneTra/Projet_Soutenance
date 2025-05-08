<?php
require_once '../app/config/database.php';

$pdo = Database::getConnection();
echo "Connexion réussie à la base de données Docker !";