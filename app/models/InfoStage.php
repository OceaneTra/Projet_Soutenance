<?php
class InfoStage {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getStageInfo($num_etu) {
        $query = "SELECT * FROM informations_stage WHERE num_etu = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveStageInfo($data) {
        try {
            // Vérifier si l'étudiant a déjà des informations de stage
            $check_query = "SELECT id_info_stage FROM informations_stage WHERE num_etu = ?";
            $check_stmt = $this->conn->prepare($check_query);
            $check_stmt->execute([$data['num_etu']]);
            $existing_info = $check_stmt->fetch();

            if ($existing_info) {
                // Mettre à jour les informations existantes
                $update_query = "UPDATE informations_stage SET 
                    id_entreprise = ?,
                    date_debut_stage = ?,
                    date_fin_stage = ?,
                    sujet_stage = ?,
                    description_stage = ?,
                    encadrant_entreprise = ?,
                    email_encadrant = ?,
                    telephone_encadrant = ?
                    WHERE num_etu = ?";
                
                $update_stmt = $this->conn->prepare($update_query);
                return $update_stmt->execute([
                    $data['entreprise'],
                    $data['date_debut'],
                    $data['date_fin'],
                    $data['sujet'],
                    $data['description'],
                    $data['encadrant'],
                    $data['email_encadrant'],
                    $data['telephone_encadrant'],
                    $data['num_etu']
                ]);
            } else {
                // Insérer de nouvelles informations
                $insert_query = "INSERT INTO informations_stage (
                    num_etu,
                    id_entreprise,
                    date_debut_stage,
                    date_fin_stage,
                    sujet_stage,
                    description_stage,
                    encadrant_entreprise,
                    email_encadrant,
                    telephone_encadrant
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $insert_stmt = $this->conn->prepare($insert_query);
                return $insert_stmt->execute([
                    $data['num_etu'],
                    $data['entreprise'],
                    $data['date_debut'],
                    $data['date_fin'],
                    $data['sujet'],
                    $data['description'],
                    $data['encadrant'],
                    $data['email_encadrant'],
                    $data['telephone_encadrant']
                ]);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getEntreprises() {
        $query = "SELECT id_entreprise, lib_entreprise FROM entreprises ORDER BY lib_entreprise";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}