<?php

require_once __DIR__ . '/../config/DbModel.class.php';



/**
 * Classe Semestre qui gère les opérations liées aux semestres
 *
 * Cette classe étend DbModel pour bénéficier des méthodes génériques d'accès à la base de données.
 */
class Semestre extends DbModel
{
    /**
     * Récupérer tous les semestres
     * @return array Liste des semestres
     */
    public function getAllSemestres(): array
    {
        return $this->selectAll(
            "SELECT * FROM semestres ORDER BY lib_semestre",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau semestre
     * @param string $lib_semestre Le libellé du semestre
     * @return bool|int L'ID du semestre créé ou false si échec
     */
    public function ajouterSemestre(string $lib_semestre): bool|int
    {
        return $this->insert(
            "INSERT INTO semestre (lib_semestre) VALUES (?)",
            [$lib_semestre]
        );
    }

    /**
     * Modifier un semestre
     * @param int $id_semestre L'ID du semestre
     * @param string $lib_semestre Le nouveau libellé du semestre
     * @return bool Succès de la modification
     */
    public function updateSemestre(int $id_semestre, string $lib_semestre): bool
    {
        return $this->update(
                "UPDATE semestre SET lib_semestre = ? WHERE id_semestre = ?",
                [$lib_semestre, $id_semestre]
            ) > 0;
    }

    /**
     * Supprimer un semestre
     * @param int $id L'ID du semestre à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteSemestre(int $id): bool
    {
        return $this->delete(
                "DELETE FROM semestre WHERE id_semestre = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer un semestre par son ID
     * @param int $id_semestre L'ID du semestre
     * @return object|null Le semestre trouvé ou null
     */
    public function getSemestreById(int $id_semestre): ?object
    {
        return $this->selectOne(
            "SELECT * FROM semestre WHERE id_semestre = ?",
            [$id_semestre],
            true
        );
    }

    /**
     * Vérifier si un semestre est utilisé
     * @param int $id_semestre L'ID du semestre
     * @return bool True si le semestre est utilisé
     */
    public function isSemestreUtilise(int $id_semestre): bool
    {
        $result = $this->selectOne(
            "SELECT COUNT(*) as count FROM ue WHERE id_semestre = ?",
            [$id_semestre]
        );
        return $result['count'] > 0;
    }
}