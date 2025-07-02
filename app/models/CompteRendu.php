<?php
require_once __DIR__ . '/../config/database.php';

class CompteRendu {
    public static function creer($num_etu, $nom_CR, $contenu_CR, $chemin_pdf, $date_CR, $rapports = []) {
        $pdo = Database::getConnection();
        // Insertion du compte rendu
        $stmt = $pdo->prepare("INSERT INTO compte_rendu (num_etu, nom_CR, contenu_CR, chemin_fichier_pdf, date_CR) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$num_etu, $nom_CR, $contenu_CR, $chemin_pdf, $date_CR]);
        $id_CR = $pdo->lastInsertId();
        // Liaisons avec les rapports
        if (!empty($rapports)) {
            $stmt2 = $pdo->prepare("INSERT INTO compte_rendu_rapport (id_CR, id_rapport) VALUES (?, ?)");
            foreach ($rapports as $id_rapport) {
                $stmt2->execute([$id_CR, $id_rapport]);
            }
        }
        return $id_CR;
    }
} 