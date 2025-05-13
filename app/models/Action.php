<?php

class Action extends DbModel
{
    /**
     * Récupérer toutes les actions
     * @return array Liste des actions
     */
    public function getAllAction(): array
    {
        return $this->selectAll("SELECT * FROM action", [], true);
    }

    /**
     * Ajouter une nouvelle action
     * @param string $libelle Le libellé de l'action
     * @return bool|int L'ID de l'action créée ou false si échec
     */
    public function addAction(string $libelle): bool|int
    {
        return $this->insert(
            "INSERT INTO action (lib_action) VALUES (?)",
            [$libelle]
        );
    }

    /**
     * Mettre à jour une action
     * @param string $lib_action Le nouveau libellé de l'action
     * @param int $id_action L'ID de l'action à modifier
     * @return bool Succès de la mise à jour
     */
    public function updateAction(string $lib_action, int $id_action): bool
    {
        return $this->update(
                "UPDATE action SET lib_action = ? WHERE id_action = ?",
                [$lib_action, $id_action]
            ) > 0;
    }

    /**
     * Supprimer une action
     * @param int $id L'ID de l'action à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteAction(int $id): bool
    {
        return $this->delete(
                "DELETE FROM action WHERE id_action = ?",
                [$id]
            ) > 0;
    }

    /**
     * Vérifier si une action existe
     * @param int $id L'ID de l'action à vérifier
     * @return bool True si l'action existe
     */
    public function isActionExiste(int $id): bool
    {
        return $this->selectOne(
                "SELECT COUNT(*) as count FROM action WHERE id_action = ?",
                [$id]
            )['count'] > 0;
    }

    /**
     * Récupérer une action par son ID
     * @param int $id_action L'ID de l'action à récupérer
     * @return object|null L'action trouvée ou null
     */
    public function getActionById(int $id_action): ?object
    {
        return $this->selectOne(
            "SELECT * FROM action WHERE id_action = ?",
            [$id_action],
            true
        );
    }
}