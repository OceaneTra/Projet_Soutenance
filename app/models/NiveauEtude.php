<?php

class NiveauEtude
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllNiveauxEtudes()
    {
        $stmt = $this->pdo->query("SELECT * FROM niveau_etude ORDER BY lib_niv_etude");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAll()
    {
        return $this->getAllNiveauxEtudes();
    }

    public function ajouterNiveauEtude($lib,$montant_scolarite,$montant_inscription)
    {
        $stmt = $this->pdo->prepare("INSERT INTO niveau_etude (lib_niv_etude,montant_scolarite,montant_inscription) VALUES (?,?,?)");
        return $stmt->execute([$lib, $montant_scolarite, $montant_inscription]);
    }

    public function updateNiveauEtude($id, $lib, $montant_scolarite,$montant_inscription)
    {
        $stmt = $this->pdo->prepare("UPDATE niveau_etude SET lib_niv_etude = ? , montant_scolarite = ?, montant_inscription= ? WHERE id_niv_etude = ?");
        return $stmt->execute([$lib,$montant_scolarite,$montant_inscription, $id]);
    }

    public function deleteNiveauEtude($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM niveau_etude WHERE id_niv_etude = ?");
        return $stmt->execute([$id]);
    }

    public function getNiveauEtudeById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM niveau_etude WHERE id_niv_etude = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}