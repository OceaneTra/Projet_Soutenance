<?php
require_once __DIR__ . '/../config/DbModel.class.php';

class Traitement extends DbModel
{
    public function ajouterTraitement($lib_traitement): int
    {
        return $this->insert("INSERT INTO traitement (lib_traitement) VALUES (?)", [$lib_traitement]);
    }

    public function updateTraitement($id_traitement, $lib_traitement): int
    {
        return $this->update("UPDATE traitement SET lib_traitement = ? WHERE id_traitement = ?", [$lib_traitement, $id_traitement]);
    }

    public function deleteTraitement($id_traitement): int
    {
        return $this->delete("DELETE FROM traitement WHERE id_traitement = ?", [$id_traitement]);
    }

    public function getTraitementById($id_traitement): object|array|null
    {
        return $this->selectOne("SELECT * FROM traitement WHERE id_traitement = ?", [$id_traitement], true);
    }

    public function getAllTraitements(): array
    {
        return $this->selectAll("SELECT * FROM traitement ORDER BY lib_traitement", [], true);
    }
}