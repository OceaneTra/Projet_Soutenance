<?php
require_once __DIR__ . '/../config/DbModel.class.php';
/**
 * Classe GroupeUtilisateur qui gère les opérations liées aux groupes utilisateurs
 *
 * Cette classe étend DbModel pour bénéficier des méthodes génériques d'accès à la base de données.
 */
class NiveauAccesDonnees extends DbModel
{
    /**
     * Récupérer tous les niveaux d'accès aux données
     * @return array Liste des niveaux d'accès
     */
    public function getAllNiveauxAcces(): array
    {
        return $this->selectAll(
            "SELECT * FROM niveau_acces_donnees ORDER BY lib_niveau_acces_donnees",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau niveau d'accès
     * @param string $lib_niveau_acces Le libellé du niveau d'accès
     * @return bool|int L'ID du niveau d'accès créé ou false si échec
     */
    public function ajouterNiveauAcces($lib_niveau_acces)
    {
        return $this->insert(
            "INSERT INTO niveau_acces_donnees (lib_niveau_acces_donnees) VALUES (?)",
            [$lib_niveau_acces]
        );
    }

    /**
     * Modifier un niveau d'accès
     * @param int $id_niveau_acces L'ID du niveau d'accès
     * @param string $lib_niveau_acces Le nouveau libellé du niveau d'accès
     * @return bool Succès de la modification
     */
    public function updateNiveauAcces($id_niveau_acces, $lib_niveau_acces)
    {
        return $this->update(
                "UPDATE niveau_acces_donnees SET lib_niveau_acces_donnees = ? WHERE id_niveau_acces_donnees = ?",
                [$lib_niveau_acces, $id_niveau_acces]
            ) > 0;
    }

    /**
     * Supprimer un niveau d'accès
     * @param int $id_niveau_acces L'ID du niveau d'accès à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteNiveauAcces($id_niveau_acces)
    {
        return $this->delete(
                "DELETE FROM niveau_acces_donnees WHERE id_niveau_acces_donnees = ?",
                [$id_niveau_acces]
            ) > 0;
    }

    /**
     * Récupérer un niveau d'accès par son ID
     * @param int $id_niveau_acces L'ID du niveau d'accès
     * @return object|null Le niveau d'accès trouvé ou null
     */
    public function getNiveauAccesById($id_niveau_acces)
    {
        return $this->selectOne(
            "SELECT * FROM niveau_acces_donnees WHERE id_niveau_acces_donnees = ?",
            [$id_niveau_acces],
            true
        );
    }

}