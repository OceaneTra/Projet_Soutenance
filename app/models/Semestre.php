<?php

class Semestre {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function ajouterSemestre($lib_semestre) {
        $stmt = $this->db->prepare("INSERT INTO semestre (lib_semestre) VALUES (?)");
        return $stmt->execute([$lib_semestre]);
    }

    public function updateSemestre($id_semestre, $lib_semestre) {
        $stmt = $this->db->prepare("UPDATE semestre SET lib_semestre = ? WHERE id_semestre = ?");
        return $stmt->execute([$lib_semestre, $id_semestre]);
    }

    public function deleteSemestre($id_semestre) {
        $stmt = $this->db->prepare("DELETE FROM semestre WHERE id_semestre = ?");
        return $stmt->execute([$id_semestre]);
    }

    public function getSemestreById($id_semestre) {
        $stmt = $this->db->prepare("SELECT * FROM semestre WHERE id_semestre = ?");
        $stmt->execute([$id_semestre]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllSemestres() {
        $stmt = $this->db->prepare("SELECT * FROM semestre ORDER BY lib_semestre");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}