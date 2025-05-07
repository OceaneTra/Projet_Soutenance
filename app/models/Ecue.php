<?php

class Ecue
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les actions
    public function getAllEcue()
    {
        $stmt = $this->pdo->query("SELECT * FROM ecue");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Ajouter une nouvelle année académique
    public function addEcue($id_ue, $libelle, $credit)
    {
        $stmt = $this->pdo->prepare("INSERT INTO ecue (id_ue, lib_ecue, credit) VALUES (?)");
        return $stmt->execute([$id_ue, $libelle, $credit]);
    }

    //mettre a jour Action
    public function updateEcue($lib_action)
    {
        $stmt = $this->pdo->prepare("UPDATE action SET lib_action = ?");
        return $stmt->execute([$lib_action]);
    }


    // Supprimer une Action
    public function deleteAction($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM action WHERE id_action = ?");
        return $stmt->execute([$id]);
    }

    // Vérifier si une action existe
    public function isActionExiste($id)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM action WHERE id_action = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn() > 0;
    }

}
