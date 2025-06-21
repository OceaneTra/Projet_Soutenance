<?php

class Ecue
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Obtenir tous les ECUEs avec les détails de leur UE associée
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

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // Ajouter un ECUE avec validation du crédit
    public function ajouterEcue($id_ue, $lib_ecue, $credit)
    {
        if (!$this->verifierCreditDisponible($id_ue, $credit)) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO ecue (id_ue, lib_ecue, credit) VALUES (?, ?, ?)");
        return $stmt->execute([$id_ue, $lib_ecue, $credit]);
    }

    // Modifier un ECUE
    public function updateEcue($id_ecue, $id_ue, $lib_ecue, $credit)
    {
        // Crédit disponible pour l'UE en excluant l'ECUE actuel
        $creditDisponible = $this->creditRestantPourUe($id_ue, $id_ecue);
        if ($credit > $creditDisponible) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE ecue SET id_ue = ?, lib_ecue = ?, credit = ? WHERE id_ecue = ?");
        return $stmt->execute([$id_ue, $lib_ecue, $credit, $id_ecue]);
    }

    // Supprimer un ECUE
    public function deleteEcue($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM ecue WHERE id_ecue = ?");
        return $stmt->execute([$id]);
    }

    // Récupérer un ECUE par son ID
    public function getEcueById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ecue WHERE id_ecue = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Crédit restant pour une UE (somme des autres ECUE)
    private function creditRestantPourUe($id_ue, $excludeEcueId = null)
    {
        $sql = "SELECT credit FROM ue WHERE id_ue = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_ue]);
        $creditUe = $stmt->fetchColumn();

        $sql = "SELECT SUM(credit) FROM ecue WHERE id_ue = ?";
        $params = [$id_ue];
        if ($excludeEcueId) {
            $sql .= " AND id_ecue != ?";
            $params[] = $excludeEcueId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $totalCredit = $stmt->fetchColumn();

        return $creditUe - ($totalCredit ?? 0);
    }

    // Vérifier si on peut ajouter ce crédit à l'UE
    public function verifierCreditDisponible($id_ue, $nouveauCredit)
    {
        $restant = $this->creditRestantPourUe($id_ue);
        return $nouveauCredit <= $restant;
    }

    public function getEcuesByNiveau(int $niveauId): array
    {
        $sql = "SELECT DISTINCT e.*, u.lib_ue, s.lib_semestre 
                FROM ecue e 
                JOIN ue u ON e.id_ue = u.id_ue 
                JOIN semestre s ON u.id_semestre = s.id_semestre 
                WHERE s.id_niv_etude = :niveau_id";
        
        $params = [':niveau_id' => $niveauId];
        
        $sql .= " ORDER BY s.lib_semestre, u.lib_ue, e.lib_ecue";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}