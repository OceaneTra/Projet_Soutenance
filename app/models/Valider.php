<?php

require_once __DIR__ . '/../config/database.php';

class Valider {
    
    /**
     * Insère une nouvelle décision de validation
     */
    public static function insererDecision($id_enseignant, $id_rapport, $decision_validation, $commentaire_validation = '') {
        try {
            $pdo = Database::getConnection();
            
            // Vérifier que la décision est valide
            if (!in_array($decision_validation, ['valider', 'rejeter'])) {
                throw new Exception("Décision invalide: $decision_validation");
            }
            
            $stmt = $pdo->prepare("
                INSERT INTO valider (id_enseignant, id_rapport, date_validation, commentaire_validation, decision_validation)
                VALUES (?, ?, NOW(), ?, ?)
            ");
            
            $result = $stmt->execute([$id_enseignant, $id_rapport, $commentaire_validation, $decision_validation]);
            
            if (!$result) {
                throw new Exception("Échec de l'insertion dans la table valider");
            }
            
            return true;
            
        } catch (Exception $e) {
            // Log l'erreur pour le débogage
            error_log("Erreur Valider::insererDecision: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Récupère toutes les décisions pour un rapport
     */
    public static function getByRapport($id_rapport) {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("
            SELECT 
                v.id_enseignant,
                v.id_rapport,
                v.date_validation,
                v.commentaire_validation,
                v.decision_validation,
                e.nom_enseignant,
                e.prenom_enseignant
            FROM valider v
            JOIN enseignants e ON v.id_enseignant = e.id_enseignant
            WHERE v.id_rapport = ?
            ORDER BY v.date_validation DESC
        ");
        
        $stmt->execute([$id_rapport]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Récupère la dernière décision pour un rapport
     */
    public static function getDerniereDecision($id_rapport) {
        $pdo = Database::getConnection();
        
        $stmt = $pdo->prepare("
            SELECT 
                v.id_enseignant,
                v.id_rapport,
                v.date_validation,
                v.commentaire_validation,
                v.decision_validation,
                e.nom_enseignant,
                e.prenom_enseignant
            FROM valider v
            JOIN enseignants e ON v.id_enseignant = e.id_enseignant
            WHERE v.id_rapport = ?
            ORDER BY v.date_validation DESC
            LIMIT 1
        ");
        
        $stmt->execute([$id_rapport]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Vérifie si un rapport a été validé
     */
    public static function estValide($id_rapport) {
        $derniereDecision = self::getDerniereDecision($id_rapport);
        return $derniereDecision && $derniereDecision['decision_validation'] === 'valider';
    }
    
    /**
     * Vérifie si un rapport a été rejeté
     */
    public static function estRejete($id_rapport) {
        $derniereDecision = self::getDerniereDecision($id_rapport);
        return $derniereDecision && $derniereDecision['decision_validation'] === 'rejeter';
    }
    
    /**
     * Récupère la liste des rapports validés (décision la plus récente = 'valider')
     */
    public static function getRapportsValides() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("
            SELECT r.id_rapport,r.num_etu, r.theme_rapport, e.prenom_etu, e.nom_etu FROM rapport_etudiants r JOIN etudiants e ON r.num_etu = e.num_etu JOIN ( SELECT id_rapport, MAX(date_validation) as last_validation FROM valider GROUP BY id_rapport ) v1 ON r.id_rapport = v1.id_rapport JOIN valider v2 ON v2.id_rapport = v1.id_rapport AND v2.date_validation = v1.last_validation;
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 