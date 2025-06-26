<?php
require_once __DIR__ . '/../config/database.php';

class RapportEtudiants {

    public static function getByEtudiant($num_etu) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM rapport_etudiants WHERE num_etu = ?");
        $stmt->execute([$num_etu]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 