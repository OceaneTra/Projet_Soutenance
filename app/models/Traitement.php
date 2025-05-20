<?php

class Traitement
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Récupère tous les traitements
     * @return array Liste des traitements
     */
    public function getAllTraitements() {
        $sql = "SELECT * FROM traitement ORDER BY lib_traitement";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les traitements attribués à un groupe d'utilisateurs
     * @param int $id_GU ID du groupe d'utilisateurs
     * @return array Liste des traitements
     */
    public function getTraitementByGU($id_GU) {
        $sql = "SELECT t.* FROM traitement t 
                INNER JOIN rattacher r ON t.id_traitement = r.id_traitement 
                WHERE r.id_GU = :id_GU 
                ORDER BY t.lib_traitement";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_GU' => $id_GU]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouveau traitement
     * @param string $lib_traitement Libellé du traitement
     * @return bool Succès de l'opération
     */
    public function ajouterTraitement($lib_traitement) {
        $sql = "INSERT INTO traitement (lib_traitement) VALUES (:lib_traitement)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':lib_traitement' => $lib_traitement]);
    }

    /**
     * Modifie un traitement existant
     * @param int $id_traitement ID du traitement
     * @param string $lib_traitement Nouveau libellé du traitement
     * @return bool Succès de l'opération
     */
    public function modifierTraitement($id_traitement, $lib_traitement) {
        $sql = "UPDATE traitement SET lib_traitement = :lib_traitement 
                WHERE id_traitement = :id_traitement";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_traitement' => $id_traitement,
            ':lib_traitement' => $lib_traitement
        ]);
    }

    /**
     * Supprime un traitement
     * @param int $id_traitement ID du traitement
     * @return bool Succès de l'opération
     */
    public function supprimerTraitement($id_traitement) {
        // Supprimer d'abord les attributions
        $sql = "DELETE FROM rattacher WHERE id_traitement = :id_traitement";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_traitement' => $id_traitement]);

        // Puis supprimer le traitement
        $sql = "DELETE FROM traitement WHERE id_traitement = :id_traitement";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id_traitement' => $id_traitement]);
    }

    public function getTraitementById($id_traitement) {
        $stmt = $this->db->prepare("SELECT * FROM traitement WHERE id_traitement = ?");
        $stmt->execute([$id_traitement]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateTraitement($id_traitement, $lib_traitement, $label_traitement, $icone_traitement, $ordre_traitement) {
        $stmt = $this->db->prepare("UPDATE traitement SET lib_traitement = ?, label_traitement = ?, icone_traitement = ?, ordre_traitement = ? WHERE id_traitement = ?");
        return $stmt->execute([$lib_traitement,$label_traitement,$icone_traitement,$ordre_traitement,$id_traitement]);
    }

    public function deleteTraitement($id_traitement) {
        $stmt = $this->db->prepare("DELETE FROM traitement WHERE id_traitement = ?");
        return $stmt->execute([$id_traitement]);
    }
}

    
    