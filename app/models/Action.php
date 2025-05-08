<?php

class Action
{



    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les actions
    public function getAllAction()
    {
        $stmt = $this->pdo->query("SELECT * FROM action");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Ajouter une nouvelle année académique
    public function addAction($libelle)
    {
        $stmt = $this->pdo->prepare("INSERT INTO action (lib_action) VALUES (?)");
        return $stmt->execute([$libelle]);
    }

    //mettre a jour Action
    public function updateAction($lib_action)
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