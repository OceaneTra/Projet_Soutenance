<?php

class Specialite
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllSpecialites()
    {
        $stmt = $this->pdo->query("SELECT * FROM specialite ORDER BY lib_specialite");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function ajouterSpecialite($lib)
    {
        $stmt = $this->pdo->prepare("INSERT INTO specialite (lib_specialite) VALUES (?)");
        return $stmt->execute([$lib]);
    }

    public function updateSpecialite($id, $lib)
    {
        $stmt = $this->pdo->prepare("UPDATE specialite SET lib_specialite = ? WHERE id_specialite = ?");
        return $stmt->execute([$lib, $id]);
    }

    public function deleteSpecialite($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM specialite WHERE id_specialite = ?");
        return $stmt->execute([$id]);
    }

    public function getSpecialiteById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM specialite WHERE id_specialite = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}