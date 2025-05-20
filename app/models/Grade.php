<?php

class Grade
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer tous les grades
    public function getAllGrades()
    {
        $stmt = $this->pdo->query("SELECT * FROM grade ORDER BY lib_grade");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Ajouter un nouveau grade
    public function ajouterGrade($lib_grade)
    {
        $stmt = $this->pdo->prepare("INSERT INTO grade (lib_grade) VALUES (?)");
        return $stmt->execute([$lib_grade]);
    }

    //Modifier un grade
    public function updateGrade($id_grade, $lib_grade)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE grade SET lib_grade = ? WHERE id_grade = ?");
            return $stmt->execute([$lib_grade, $id_grade]);
        } catch (PDOException $e) {
            error_log("Erreur pendant la maj du grade" . $e->getMessage());
            return false;
        }
    }

    // Supprimer un grade
    public function deleteGrade($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM grade WHERE id_grade = ?");
        return $stmt->execute([$id]);
    }

    public function getGradeById($id_grade)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM grade WHERE id_grade = ?");
        $stmt->execute([$id_grade]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}