<?php

class Ue
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les EU
    public function getAllEu()
    {
        $stmt = $this->pdo->query("SELECT * FROM ue");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Ajouter une nouvelle UE
    public function addEu($lib_ue, $credit)
    {
        $stmt = $this->pdo->prepare("INSERT INTO eu (lib_ue, credit) VALUES (? , ?)");
        return $stmt->execute([$lib_ue, $credit]);
    }

    //mettre a jour UE
    public function updateAction($id_ue, $lib_ue, $credit)
    {
        $stmt = $this->pdo->prepare("UPDATE ue SET lib_ue = ?, credit = ? WHERE id_ue = ?");
        return $stmt->execute([$lib_ue, $credit, $id_ue]);
    }


    // Supprimer une UE
    public function deleteUe($id_ue)
    {
        $stmt = $this->pdo->prepare("DELETE FROM ue WHERE id_ue = ?");
        return $stmt->execute([$id_ue]);
    }

    // Vérifier si une action existe
    public function isUeExiste($id_ue)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM action WHERE id_ue = ?");
        $stmt->execute([$id_ue]);
        return $stmt->fetchColumn() > 0;
    }

}