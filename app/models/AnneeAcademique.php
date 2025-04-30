<?php

class AnneeAcademique {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les années académiques
    public function getAllAnneeAcademiques() {
        $stmt = $this->pdo->query("SELECT * FROM annee_academique ORDER BY date_deb DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter une nouvelle année académique
    public function addAnneeAcademique($date_deb, $date_fin) {
        // Récupération des années
        $annee1 = date("Y", strtotime($date_deb));
        $annee2 = date("Y", strtotime($date_fin));

        // Génération de l'ID selon la logique existante
        $id_annee_acad = substr($annee2, 0, 1) . substr($annee1, 2, 2) . substr($annee2, 2, 2);

        $stmt = $this->pdo->prepare("INSERT INTO annee_academique (id_annee_acad, date_deb, date_fin) VALUES (?, ?, ?)");
        return $stmt->execute([$id_annee_acad, $date_deb, $date_fin]);
    }

    // Supprimer une année académique
    public function deleteAnneeAcademique($id) {
        $stmt = $this->pdo->prepare("DELETE FROM annee_academique WHERE id_annee_acad = ?");
        return $stmt->execute([$id]);
    }

    // Vérifier si une année académique est utilisée
    public function isAnneeAcademiqueInUse($id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM inscrire WHERE id_annee_acad = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
}