<?php
require_once __DIR__ . '/../config/DbModel.class.php';

/**
 * Gère les groupes utilisateurs
 */
class GroupeUtilisateur extends DbModel
{
    /**
     * Récupérer tous les groupes utilisateurs
     * @return array Liste des groupes utilisateurs
     */
    public function getAllGroupeUtilisateur(): array
    {
        return $this->selectAll(
            "SELECT * FROM groupe_utilisateur ORDER BY lib_GU",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau groupe utilisateur
     * @param string $lib_GU Le libellé du groupe utilisateur
     * @return bool|int L'ID du groupe créé ou false si échec
     */
    public function ajouterGroupeUtilisateur(string $lib_GU): bool|int
    {
        return $this->insert(
            "INSERT INTO groupe_utilisateur (lib_GU) VALUES (?)",
            [$lib_GU]
        );
    }

    /**
     * Modifier un groupe utilisateur
     * @param int $id_GU L'ID du groupe utilisateur
     * @param string $lib_GU Le nouveau libellé du groupe utilisateur
     * @return bool Succès de la modification
     */
    public function updateGroupeUtilisateur(int $id_GU, string $lib_GU): bool
    {
        return $this->update(
                "UPDATE groupe_utilisateur SET lib_GU = ? WHERE id_GU = ?",
                [$lib_GU, $id_GU]
            ) > 0;
    }

    /**
     * Supprimer un groupe utilisateur
     * @param int $id L'ID du groupe utilisateur à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteGroupeUtilisateur(int $id): bool
    {
        return $this->delete(
                "DELETE FROM groupe_utilisateur WHERE id_GU = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer un groupe utilisateur par son ID
     * @param int $id_GU L'ID du groupe utilisateur
     * @return object|null Le groupe utilisateur trouvé ou null
     */
    public function getGroupeUtilisateurById(int $id_GU): ?object
    {
        return $this->selectOne(
            "SELECT * FROM groupe_utilisateur WHERE id_GU = ?",
            [$id_GU],
            true
        );
    }


}