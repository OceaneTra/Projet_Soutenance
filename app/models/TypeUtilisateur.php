<?php

class TypeUtilisateur extends DbModel
{
    /**
     * Récupérer tous les types d'utilisateur
     * @return array Liste des types d'utilisateur
     */
    public function getAllTypeUtilisateur(): array
    {
        return $this->selectAll(
            "SELECT * FROM type_utilisateur ORDER BY lib_type_utilisateur",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau type d'utilisateur
     * @param string $lib_type_utilisateur Le libellé du type d'utilisateur
     * @return bool|int L'ID du type d'utilisateur créé ou false si échec
     */
    public function ajouterTypeUtilisateur(string $lib_type_utilisateur): bool|int
    {
        return $this->insert(
            "INSERT INTO type_utilisateur (lib_type_utilisateur) VALUES (?)",
            [$lib_type_utilisateur]
        );
    }

    /**
     * Modifier un type d'utilisateur
     * @param int $id_type_utilisateur L'ID du type d'utilisateur
     * @param string $lib_type_utilisateur Le nouveau libellé du type d'utilisateur
     * @return bool Succès de la modification
     */
    public function updateTypeUtilisateur(int $id_type_utilisateur, string $lib_type_utilisateur): bool
    {
        return $this->update(
                "UPDATE type_utilisateur SET lib_type_utilisateur = ? WHERE id_type_utilisateur = ?",
                [$lib_type_utilisateur, $id_type_utilisateur]
            ) > 0;
    }

    /**
     * Supprimer un type d'utilisateur
     * @param int $id L'ID du type d'utilisateur à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteTypeUtilisateur(int $id): bool
    {
        return $this->delete(
                "DELETE FROM type_utilisateur WHERE id_type_utilisateur = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer un type d'utilisateur par son ID
     * @param int $id_type L'ID du type d'utilisateur à récupérer
     * @return object|null Le type d'utilisateur trouvé ou null
     */
    public function getTypeUtilisateurById(int $id_type): ?object
    {
        return $this->selectOne(
            "SELECT * FROM type_utilisateur WHERE id_type_utilisateur = ?",
            [$id_type],
            true
        );
    }
}