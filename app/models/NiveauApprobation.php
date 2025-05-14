<?php
require_once __DIR__ . '/../config/DbModel.class.php';
/**
 * Classe GroupeUtilisateur qui gère les opérations liées aux groupes utilisateurs
 *
 * Cette classe étend DbModel pour bénéficier des méthodes génériques d'accès à la base de données.
 */
class NiveauApprobation extends DbModel
{
    /**
     * Ajouter un nouveau niveau d'approbation
     * @param string $lib_approb Le libellé du niveau d'approbation
     * @return bool|int L'ID du niveau d'approbation créé ou false si échec
     */
    public function ajouterNiveauApprobation(string $lib_approb): bool|int
    {
        return $this->insert(
            "INSERT INTO niveau_approbation (lib_approb) VALUES (?)",
            [$lib_approb]
        );
    }

    /**
     * Modifier un niveau d'approbation
     * @param int $id_approb L'ID du niveau d'approbation
     * @param string $lib_approb Le nouveau libellé du niveau d'approbation
     * @return bool Succès de la modification
     */
    public function updateNiveauApprobation(int $id_approb, string $lib_approb): bool
    {
        return $this->update(
                "UPDATE niveau_approbation SET lib_approb = ? WHERE id_approb = ?",
                [$lib_approb, $id_approb]
            ) > 0;
    }

    /**
     * Supprimer un niveau d'approbation
     * @param int $id_approb L'ID du niveau d'approbation à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteNiveauApprobation(int $id_approb): bool
    {
        return $this->delete(
                "DELETE FROM niveau_approbation WHERE id_approb = ?",
                [$id_approb]
            ) > 0;
    }

    /**
     * Récupérer un niveau d'approbation par son ID
     * @param int $id_approb L'ID du niveau d'approbation
     * @return object|null Le niveau d'approbation trouvé ou null
     */
    public function getNiveauApprobationById(int $id_approb): ?object
    {
        return $this->selectOne(
            "SELECT * FROM niveau_approbation WHERE id_approb = ?",
            [$id_approb],
            true
        );
    }

    /**
     * Récupérer tous les niveaux d'approbation
     * @return array Liste des niveaux d'approbation
     */
    public function getAllNiveauxApprobation(): array
    {
        return $this->selectAll(
            "SELECT * FROM niveau_approbation ORDER BY lib_approb",
            [],
            true
        );
    }

    /**
     * Vérifier si un niveau d'approbation est utilisé
     * @param int $id_approb L'ID du niveau d'approbation
     * @return bool True si le niveau d'approbation est utilisé
     */
    public function isNiveauApprobationUtilise(int $id_approb): bool
    {
        $result = $this->selectOne(
            "SELECT COUNT(*) as count FROM niveau_approbation WHERE id_approb = ?",
            [$id_approb]
        );
        return $result['count'] > 0;
    }
}