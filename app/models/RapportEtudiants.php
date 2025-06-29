<?php
require_once __DIR__ . '/../config/database.php';

class RapportEtudiants {

    public static function getByEtudiant($num_etu) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM rapport_etudiants WHERE num_etu = ?");
        $stmt->execute([$num_etu]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id_rapport) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT r.*, e.nom_etu, e.prenom_etu, e.email_etu, e.promotion_etu, d.date_depot
            FROM rapport_etudiants r
            JOIN etudiants e ON r.num_etu = e.num_etu
            JOIN deposer d ON r.id_rapport = d.id_rapport
            WHERE r.id_rapport = ?");
        $stmt->execute([$id_rapport]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 