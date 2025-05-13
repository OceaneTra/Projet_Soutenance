<?php

class StatutJury extends DbModel
{
    /**
     * Récupérer tous les statuts de jury
     * @return array Liste des statuts de jury
     */
    public function getAllStatutsJury(): array
    {
        return $this->selectAll(
            "SELECT * FROM statut_jury ORDER BY lib_jury",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau statut de jury
     * @param string $lib Le libellé du statut
     * @return bool|int L'ID du statut créé ou false si échec
     */
    public function ajouterStatutJury(string $lib): bool|int
    {
        return $this->insert(
            "INSERT INTO statut_jury (lib_jury) VALUES (?)",
            [$lib]
        );
    }

    /**
     * Modifier un statut de jury
     * @param int $id L'ID du statut
     * @param string $lib Le nouveau libellé du statut
     * @return bool Succès de la modification
     */
    public function updateStatutJury(int $id, string $lib): bool
    {
        return $this->update(
                "UPDATE statut_jury SET lib_jury = ? WHERE id_jury = ?",
                [$lib, $id]
            ) > 0;
    }

    /**
     * Supprimer un statut de jury
     * @param int $id L'ID du statut à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteStatutJury(int $id): bool
    {
        return $this->delete(
                "DELETE FROM statut_jury WHERE id_jury = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer un statut de jury par son ID
     * @param int $id L'ID du statut
     * @return object|null Le statut trouvé ou null
     */
    public function getStatutJuryById(int $id): ?object
    {
        return $this->selectOne(
            "SELECT * FROM statut_jury WHERE id_jury = ?",
            [$id],
            true
        );
    }

    /**
     * Vérifier si un statut de jury est utilisé
     * @param int $id L'ID du statut
     * @return bool True si le statut est utilisé
     */
    public function isStatutJuryUtilise(int $id): bool
    {
        $result = $this->selectOne(
            "SELECT COUNT(*) as count FROM statut_jury WHERE id_jury = ?",
            [$id]
        );
        return $result['count'] > 0;
    }
}