<?php
require_once __DIR__ . '/../config/DbModel.class.php';

class Entreprise extends DbModel
{
    public function ajouterEntreprise($lib_entreprise): int
    {
        return $this->insert("INSERT INTO entreprises (lib_entreprise) VALUES (?)", [$lib_entreprise]);
    }

    public function updateEntreprise($id_entreprise, $lib_entreprise): int
    {
        return $this->update("UPDATE entreprises SET lib_entreprise = ? WHERE id_entreprise = ?", [$lib_entreprise, $id_entreprise]);
    }

    public function deleteEntreprise($id_entreprise): int
    {
        return $this->delete("DELETE FROM entreprises WHERE id_entreprise = ?", [$id_entreprise]);
    }

    public function getEntrepriseById($id_entreprise): object|array|null
    {
        return $this->selectOne("SELECT * FROM entreprises WHERE id_entreprise = ?", [$id_entreprise], true);
    }

    public function getAllEntreprises(): array
    {
        return $this->selectAll("SELECT * FROM entreprises ORDER BY lib_entreprise", [], true);
    }
}