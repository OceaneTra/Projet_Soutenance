<?php
require_once __DIR__ . '/../config/database.php';

class Approuver {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public static function getByRapport($id_rapport) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT a.*, n.lib_approb, p.nom_pers_admin, p.prenom_pers_admin
            FROM approuver a
            JOIN niveau_approbation n ON a.id_approb = n.id_approb
            JOIN personnel_admin p ON a.id_pers_admin = p.id_pers_admin
            WHERE a.id_rapport = ?
            ORDER BY a.date_approv ASC");
        $stmt->execute([$id_rapport]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 