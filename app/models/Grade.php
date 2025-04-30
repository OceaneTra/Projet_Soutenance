<?php

class Grade {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les grades
    public function getAllGrades() {
        $stmt = $this->pdo->query("SELECT * FROM grade ORDER BY lib_grade");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Générer un code pour un grade
    private function genererCodeGrade($libelle) {
        $correspondances = [
            "assistant" => "ASS",
            "maitre-assistant" => "MA",
            "maitre de conferences" => "MCF",
            "professeur des universites" => "PU",
            "charge de cours" => "CC",
            "vacataire" => "VAC",
            "attache temporaire d'enseignement et de recherche" => "ATER",
            "docteur hdr" => "HDR"
        ];

        // Normalisation : minuscules + suppression accents
        $libelle = strtolower(trim($libelle));
        $libelle = str_replace(
            ["é", "è", "ê", "ë", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", "ç", "'", "'"],
            ["e", "e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "c", "", ""],
            $libelle
        );

        return $correspondances[$libelle] ?? null;
    }

    // Ajouter un nouveau grade
    public function addGrade($lib_grade) {
        $id_grade = $this->genererCodeGrade($lib_grade);

        if ($id_grade === null) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO grade (id_grade, lib_grade) VALUES (?, ?)");
        return $stmt->execute([$id_grade, $lib_grade]);
    }

    // Supprimer un grade
    public function deleteGrade($id) {
        $stmt = $this->pdo->prepare("DELETE FROM grade WHERE id_grade = ?");
        return $stmt->execute([$id]);
    }
}