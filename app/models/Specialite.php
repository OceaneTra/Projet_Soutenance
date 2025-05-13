<?php

class Specialite extends DbModel
{
    /**
     * Récupérer toutes les spécialités
     * @return array Liste des spécialités
     */
    public function getAllSpecialites(): array
    {
        return $this->selectAll(
            "SELECT * FROM specialite ORDER BY lib_specialite",
            [],
            true
        );
    }

    /**
     * Ajouter une nouvelle spécialité
     * @param string $lib_specialite Le libellé de la spécialité
     * @return bool|int L'ID de la spécialité créée ou false si échec
     */
    public function ajouterSpecialite(string $lib_specialite): bool|int
    {
        return $this->insert(
            "INSERT INTO specialite (lib_specialite) VALUES (?)",
            [$lib_specialite]
        );
    }

    /**
     * Modifier une spécialité
     * @param int $id_specialite L'ID de la spécialité
     * @param string $lib_specialite Le nouveau libellé de la spécialité
     * @return bool Succès de la modification
     */
    public function updateSpecialite(int $id_specialite, string $lib_specialite): bool
    {
        return $this->update(
                "UPDATE specialite SET lib_specialite = ? WHERE id_specialite = ?",
                [$lib_specialite, $id_specialite]
            ) > 0;
    }

    /**
     * Supprimer une spécialité
     * @param int $id_specialite L'ID de la spécialité à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteSpecialite(int $id_specialite): bool
    {
        return $this->delete(
                "DELETE FROM specialite WHERE id_specialite = ?",
                [$id_specialite]
            ) > 0;
    }

    /**
     * Récupérer une spécialité par son ID
     * @param int $id_specialite L'ID de la spécialité
     * @return object|null La spécialité trouvée ou null
     */
    public function getSpecialiteById(int $id_specialite): ?object
    {
        return $this->selectOne(
            "SELECT * FROM specialite WHERE id_specialite = ?",
            [$id_specialite],
            true
        );
    }

    /**
     * Vérifier si une spécialité est utilisée
     * @param int $id_specialite L'ID de la spécialité
     * @return bool True si la spécialité est utilisée
     */
    public function isSpecialiteUtilisee(int $id_specialite): bool
    {
        $result = $this->selectOne(
            "SELECT COUNT(*) as count FROM enseignants WHERE id_specialite = ?",
            [$id_specialite]
        );
        return $result['count'] > 0;
    }
}