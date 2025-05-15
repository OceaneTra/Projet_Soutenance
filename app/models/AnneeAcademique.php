<?php

class AnneeAcademique {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllAnneeAcademiques() {
        $stmt = $this->pdo->query("SELECT * FROM annee_academique ORDER BY date_deb DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAnneeAcademiqueById($id_annee_acad) {
        $stmt = $this->pdo->prepare("SELECT * FROM annee_academique WHERE id_annee_acad = ?");
        $stmt->execute([$id_annee_acad]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ajouterAnneeAcademique($date_deb, $date_fin) {
        $annee1 = date("Y", strtotime($date_deb));
        $annee2 = date("Y", strtotime($date_fin));
        $id_annee_acad = substr($annee2, 0, 1) . substr($annee1, 2, 2) . substr($annee2, 2, 2);

        try {
        $stmt = $this->pdo->prepare("INSERT INTO annee_academique (id_annee_acad, date_deb, date_fin) VALUES (?, ?, ?)");
        return $stmt->execute([$id_annee_acad, $date_deb, $date_fin]);
        } catch (PDOException $e) {
            error_log("Erreur d'ajout d'année académique: " . $e->getMessage());
            return false;
    }
    }

    public function updateAnneeAcademique($id_annee_acad, $date_deb, $date_fin) {
        // Calculer le nouvel ID basé sur les nouvelles dates
        $annee1 = date("Y", strtotime($date_deb));
        $annee2 = date("Y", strtotime($date_fin));
        $nouvel_id = substr($annee2, 0, 1) . substr($annee1, 2, 2) . substr($annee2, 2, 2);

        try {
            $stmt = $this->pdo->prepare("UPDATE annee_academique SET id_annee_acad = ?, date_deb = ?, date_fin = ? WHERE id_annee_acad = ?");
            return $stmt->execute([$nouvel_id, $date_deb, $date_fin, $id_annee_acad]);
        } catch (PDOException $e) {
            error_log("Erreur de mise à jour d'année académique: " . $e->getMessage());
            return false;
        }
    }

    public function deleteAnneeAcademique($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM annee_academique WHERE id_annee_acad = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur de suppression d'année académique: " . $e->getMessage());
            return false;
    }
}

    public function isAnneeAcademiqueInUse($id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM autre_table_utilisant_annee WHERE id_annee_acad = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }
}