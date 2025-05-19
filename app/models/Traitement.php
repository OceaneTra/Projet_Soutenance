<?php

class Traitement
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterTraitement($lib_traitement, $label_traitement, $icone_traitement, $ordre_traitement) {
        $stmt = $this->db->prepare("INSERT INTO traitement (lib_traitement,label_traitement,icone_traitement,ordre_traitement) VALUES (?,?,?,?)");
        return $stmt->execute([$lib_traitement], [$label_traitement], [$icone_traitement], [$ordre_traitement]);
    }

    public function updateTraitement($id_traitement, $lib_traitement, $label_traitement, $icone_traitement, $ordre_traitement) {
        $stmt = $this->db->prepare("UPDATE traitement SET lib_traitement = ?, label_traitement = ?, icone_traitement = ?, ordre_traitement = ? WHERE id_traitement = ?");
        return $stmt->execute([$lib_traitement, $id_traitement], [$label_traitement], [$icone_traitement], [$ordre_traitement]);
    }

    public function deleteTraitement($id_traitement) {
        $stmt = $this->db->prepare("DELETE FROM traitement WHERE id_traitement = ?");
        return $stmt->execute([$id_traitement]);
    }

    public function getTraitementById($id_traitement) {
        $stmt = $this->db->prepare("SELECT * FROM traitement WHERE id_traitement = ?");
        $stmt->execute([$id_traitement]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllTraitements() {
        $stmt = $this->db->prepare("SELECT * FROM traitement ORDER BY lib_traitement");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTraitementByGU($id_GU) {
        $stmt = $this->db->prepare("SELECT t.* FROM traitement t 
        JOIN rattacher r ON r.id_traitement = t.id_traitement
        WHERE r.id_GU = ?");
        $stmt->execute([$id_GU]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}

    
    