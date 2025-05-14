<?php

class Entreprise
{


    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterEntreprise($lib_entreprise)
    {
        $stmt = $this->db->prepare("INSERT INTO entreprises (lib_entreprise) VALUES (?)");
        return $stmt->execute([$lib_entreprise]);
    }

    public function updateEntreprise($id_entreprise, $lib_entreprise)
    {
        $stmt = $this->db->prepare("UPDATE entreprises SET lib_entreprise = ? WHERE id_entreprise = ?");
        return $stmt->execute([$lib_entreprise, $id_entreprise]);
    }

    public function deleteEntreprise($id_entreprise)
    {
        $stmt = $this->db->prepare("DELETE FROM entreprises WHERE id_entreprise = ?");
        return $stmt->execute([$id_entreprise]);
    }

    public function getEntrepriseById($id_entreprise)
    {
        $stmt = $this->db->prepare("SELECT * FROM entreprises WHERE id_entreprise = ?");
        $stmt->execute([$id_entreprise]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllEntreprises()
    {
        $stmt = $this->db->prepare("SELECT * FROM entreprises ORDER BY lib_entreprise");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}