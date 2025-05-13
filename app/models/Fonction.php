<?php

class Fonction {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterFonction($lib_fonction)
    {
        $stmt = $this->db->prepare("INSERT INTO fonction (lib_fonction) VALUES (?)");
        return $stmt->execute([$lib_fonction]);
    }

    public function updateFonction($id_fonction, $lib_fonction)
    {
        $stmt = $this->db->prepare("UPDATE fonction SET lib_fonction = ? WHERE id_fonction = ?");
        return $stmt->execute([$lib_fonction, $id_fonction]);
    }

    public function deleteFonction($id_fonction)
    {
        $stmt = $this->db->prepare("DELETE FROM fonction WHERE id_fonction = ?");
        return $stmt->execute([$id_fonction]);
    }

    public function getFonctionById($id_fonction)
    {
        $stmt = $this->db->prepare("SELECT * FROM fonction WHERE id_fonction = ?");
        $stmt->execute([$id_fonction]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllfonction()
    {
        $stmt = $this->db->prepare("SELECT * FROM fonction ORDER BY lib_fonction");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}