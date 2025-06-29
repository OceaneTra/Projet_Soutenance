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

    public function insererApprobation($id_pers_admin, $id_rapport, $decision, $commentaire) {
        try {
            error_log("DEBUG: insererApprobation - id_pers_admin: $id_pers_admin, id_rapport: $id_rapport, decision: $decision, commentaire: $commentaire");
            
            // Convertir la décision en format attendu par la base de données
            $decision_db = ($decision === 'Approuvé') ? 'approuve' : 'desapprouve';
            error_log("DEBUG: decision convertie: $decision_db");
            
            $stmt = $this->pdo->prepare("
                INSERT INTO approuver (id_approb, id_pers_admin, id_rapport, decision, date_approv, commentaire_approv) 
                VALUES (3,?, ?, ?, NOW(), ?)
            ");
            
            $result = $stmt->execute([$id_pers_admin, $id_rapport, $decision_db, $commentaire]);
            error_log("DEBUG: Résultat execute: " . ($result ? 'true' : 'false'));
            
            if (!$result) {
                error_log("DEBUG: Erreur PDO: " . print_r($stmt->errorInfo(), true));
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur insertion approbation: " . $e->getMessage());
            error_log("DEBUG: Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }
} 