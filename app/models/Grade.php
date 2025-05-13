<?php

class Grade extends DbModel
{
    /**
     * Récupérer tous les grades
     * @return array Liste des grades
     */
    public function getAllGrades(): array
    {
        return $this->selectAll(
            "SELECT * FROM grade ORDER BY lib_grade",
            [],
            true
        );
    }

    /**
     * Ajouter un nouveau grade
     * @param string $lib_grade Le libellé du grade
     * @return bool|int L'ID du grade créé ou false si échec
     */
    public function ajouterGrade(string $lib_grade): bool|int
    {
        return $this->insert(
            "INSERT INTO grade (lib_grade) VALUES (?)",
            [$lib_grade]
        );
    }

    /**
     * Modifier un grade
     * @param int $id_grade L'ID du grade
     * @param string $lib_grade Le nouveau libellé du grade
     * @return bool Succès de la modification
     */
    public function updateGrade(int $id_grade, string $lib_grade): bool
    {
        return $this->update(
                "UPDATE grade SET lib_grade = ? WHERE id_grade = ?",
                [$lib_grade, $id_grade]
            ) > 0;
    }

    /**
     * Supprimer un grade
     * @param int $id L'ID du grade à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteGrade(int $id): bool
    {
        return $this->delete(
                "DELETE FROM grade WHERE id_grade = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer un grade par son ID
     * @param int $id_grade L'ID du grade
     * @return object|null Le grade trouvé ou null
     */
    public function getGradeById(int $id_grade): ?object
    {
        return $this->selectOne(
            "SELECT * FROM grade WHERE id_grade = ?",
            [$id_grade],
            true
        );
    }
}