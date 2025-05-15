<?php

require_once __DIR__ . '/../config/DbModel.class.php';

class Ecue extends DbModel
{
    /**
     * Obtenir tous les ECUEs avec les détails de leur UE associée
     *
     * @return array Liste des ECUEs avec leurs détails
     */
    public function getAllEcues()
    {
        $sql = "SELECT e.*, u.lib_ue, u.credit AS ue_credit, 
                       n.lib_niv_etude, s.lib_semestre, a.id_annee_acad
                FROM ecue e
                JOIN ue u ON e.id_ue = u.id_ue
                JOIN niveau_etude n ON u.id_niveau_etude = n.id_niv_etude
                JOIN semestre s ON u.id_semestre = s.id_semestre
                JOIN annee_academique a ON u.id_annee_academique = a.id_annee_acad
                ORDER BY e.lib_ecue";

        return $this->selectAll($sql, [], true);
    }

    /**
     * Ajouter un ECUE avec validation du crédit
     *
     * @param int $id_ue ID de l'UE
     * @param string $lib_ecue Libellé de l'ECUE
     * @param int $credit Crédit de l'ECUE
     * @return bool|int ID de l'ECUE créé ou false si échec
     */
    public function ajouterEcue(int $id_ue, string $lib_ecue, int $credit): bool|int
    {
        if (!$this->verifierCreditDisponible($id_ue, $credit)) {
            return false;
        }

        return $this->insert(
            "INSERT INTO ecue (id_ue, lib_ecue, credit) VALUES (?, ?, ?)",
            [$id_ue, $lib_ecue, $credit]
        );
    }

    /**
     * Modifier un ECUE
     *
     * @param int $id_ecue ID de l'ECUE
     * @param int $id_ue ID de l'UE
     * @param string $lib_ecue Libellé de l'ECUE
     * @param int $credit Crédit de l'ECUE
     * @return bool Succès de la modification
     */
    public function updateEcue(int $id_ecue, int $id_ue, string $lib_ecue, int $credit): bool
    {
        $creditDisponible = $this->creditRestantPourUe($id_ue, $id_ecue);
        if ($credit > $creditDisponible) {
            return false;
        }

        return $this->update(
                "UPDATE ecue SET id_ue = ?, lib_ecue = ?, credit = ? WHERE id_ecue = ?",
                [$id_ue, $lib_ecue, $credit, $id_ecue]
            ) > 0;
    }

    /**
     * Supprimer un ECUE
     *
     * @param int $id ID de l'ECUE à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteEcue(int $id): bool
    {
        return $this->delete("DELETE FROM ecue WHERE id_ecue = ?", [$id]) > 0;
    }

    /**
     * Récupérer un ECUE par son ID
     *
     * @param int $id ID de l'ECUE
     * @return object|null L'ECUE trouvé ou null
     */
    public function getEcueById(int $id): ?object
    {
        return $this->selectOne(
            "SELECT * FROM ecue WHERE id_ecue = ?",
            [$id],
            true
        );
    }

    /**
     * Crédit restant pour une UE (somme des autres ECUE)
     *
     * @param int $id_ue ID de l'UE
     * @param int|null $excludeEcueId ID de l'ECUE à exclure du calcul
     * @return float Crédit restant disponible
     */
    private function creditRestantPourUe(int $id_ue, int $excludeEcueId = null): float
    {
        $creditUe = $this->selectOne(
            "SELECT credit FROM ue WHERE id_ue = ?",
            [$id_ue]
        )['credit'];

        $sql = "SELECT COALESCE(SUM(credit), 0) as total FROM ecue WHERE id_ue = ?";
        $params = [$id_ue];

        if ($excludeEcueId) {
            $sql .= " AND id_ecue != ?";
            $params[] = $excludeEcueId;
        }

        $totalCredit = $this->selectOne($sql, $params)['total'];
        return $creditUe - $totalCredit;
    }

    /**
     * Vérifier si on peut ajouter ce crédit à l'UE
     *
     * @param int $id_ue ID de l'UE
     * @param float $nouveauCredit Crédit à vérifier
     * @return bool True si le crédit peut être ajouté
     */
    public function verifierCreditDisponible(int $id_ue, float $nouveauCredit): bool
    {
        $restant = $this->creditRestantPourUe($id_ue);
        return $nouveauCredit <= $restant;
    }
}
