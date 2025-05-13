<?php

class Ue extends DbModel
{
    /**
     * Récupérer toutes les UEs avec leurs détails
     * @return array Liste des UEs
     */
    public function getAllUes(): array
    {
        return $this->selectAll(
            "SELECT ue.*, n.lib_niv_etude, s.lib_semestre, CONCAT(a.date_deb, ' / ', a.date_fin) AS annee 
             FROM ue 
             JOIN niveau_etude n ON ue.id_niveau_etude = n.id_niv_etude
             JOIN semestre s ON ue.id_semestre = s.id_semestre
             JOIN annee_academique a ON ue.id_annee_academique = a.id_annee_acad
             ORDER BY lib_ue",
            [],
            true
        );
    }

    /**
     * Ajouter une nouvelle UE
     * @param string $lib_ue Le libellé de l'UE
     * @param int $id_niveau_etude L'ID du niveau d'étude
     * @param int $id_semestre L'ID du semestre
     * @param string $id_annee_academique L'ID de l'année académique
     * @param int $credit Le nombre de crédits
     * @return bool|int L'ID de l'UE créée ou false si échec
     */
    public function ajouterUe(string $lib_ue, int $id_niveau_etude, int $id_semestre, string $id_annee_academique, int $credit): bool|int
    {
        return $this->insert(
            "INSERT INTO ue (lib_ue, id_niveau_etude, id_semestre, id_annee_academique, credit) VALUES (?, ?, ?, ?, ?)",
            [$lib_ue, $id_niveau_etude, $id_semestre, $id_annee_academique, $credit]
        );
    }

    /**
     * Modifier une UE
     * @param int $id_ue L'ID de l'UE
     * @param string $lib_ue Le nouveau libellé de l'UE
     * @param int $id_niveau_etude L'ID du niveau d'étude
     * @param int $id_semestre L'ID du semestre
     * @param string $id_annee_academique L'ID de l'année académique
     * @param int $credit Le nouveau nombre de crédits
     * @return bool Succès de la modification
     */
    public function updateUe(int $id_ue, string $lib_ue, int $id_niveau_etude, int $id_semestre, string $id_annee_academique, int $credit): bool
    {
        return $this->update(
                "UPDATE ue SET lib_ue = ?, id_niveau_etude = ?, id_semestre = ?, id_annee_academique = ?, credit = ? WHERE id_ue = ?",
                [$lib_ue, $id_niveau_etude, $id_semestre, $id_annee_academique, $credit, $id_ue]
            ) > 0;
    }

    /**
     * Supprimer une UE
     * @param int $id L'ID de l'UE à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteUe(int $id): bool
    {
        return $this->delete(
                "DELETE FROM ue WHERE id_ue = ?",
                [$id]
            ) > 0;
    }

    /**
     * Récupérer une UE par son ID
     * @param int $id L'ID de l'UE
     * @return object|null L'UE trouvée ou null
     */
    public function getUeById(int $id): ?object
    {
        return $this->selectOne(
            "SELECT * FROM ue WHERE id_ue = ?",
            [$id],
            true
        );
    }
}
