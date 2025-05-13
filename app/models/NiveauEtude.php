<?php
require_once __DIR__ . '/../config/DbModel.class.php';
/**
 * Classe Fonction qui gère les opérations liées aux fonctions
 *
 * Cette classe étend DbModel pour bénéficier des méthodes génériques d'accès à la base de données.
 */

class NiveauEtude extends DbModel
{
    /**
     * Récupérer tous les niveaux d'études
     * @return array Liste des niveaux d'études
     */
    public function getAllNiveauxEtudes(): array
    {
        return $this->selectAll(
            "SELECT * FROM niveau_etude ORDER BY lib_niv_etude",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau niveau d'étude
     * @param string $lib Le libellé du niveau d'étude
     * @return bool|int L'ID du niveau d'étude créé ou false si échec
     */
    public function ajouterNiveauEtude(string $lib): bool|int
    {
        return $this->insert(
            "INSERT INTO niveau_etude (lib_niv_etude) VALUES (?)",
            [$lib]
        );
    }

    /**
     * Modifier un niveau d'étude
     * @param int $id L'ID du niveau d'étude
     * @param string $lib Le nouveau libellé du niveau d'étude
     * @return bool Succès de la modification
     */
    public function updateNiveauEtude(int $id, string $lib): bool
    {
        return $this->update(
                "UPDATE niveau_etude SET lib_niv_etude = ? WHERE id_niv_etude = ?",
                [$lib, $id]
            ) > 0;
    }

    /**
     * Supprimer un niveau d'étude
     * @param int $id L'ID du niveau d'étude à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteNiveauEtude(int $id): bool
    {
        return $this->delete(
                "DELETE FROM niveau_etude WHERE id_niv_etude = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer un niveau d'étude par son ID
     * @param int $id L'ID du niveau d'étude
     * @return object|null Le niveau d'étude trouvé ou null
     */
    public function getNiveauEtudeById(int $id): ?object
    {
        return $this->selectOne(
            "SELECT * FROM niveau_etude WHERE id_niv_etude = ?",
            [$id],
            true
        );
    }

    /**
     * Vérifier si un niveau d'étude est utilisé
     * @param int $id L'ID du niveau d'étude
     * @return bool True si le niveau d'étude est utilisé
     */
    public function isNiveauEtudeUtilise(int $id): bool
    {
        $result = $this->selectOne(
            "SELECT COUNT(*) as count FROM ue WHERE id_niveau_etude = ?",
            [$id]
        );
        return $result['count'] > 0;
    }
}