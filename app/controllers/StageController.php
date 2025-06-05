<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté et est un étudiant
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

$num_etu = $_SESSION['user']['num_etu'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $entreprise = $_POST['entreprise'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $sujet = $_POST['sujet'];
        $description = $_POST['description'];
        $encadrant = $_POST['encadrant'];
        $email_encadrant = $_POST['email_encadrant'];
        $telephone_encadrant = $_POST['telephone_encadrant'];

        // Vérifier si l'étudiant a déjà des informations de stage
        $check_query = "SELECT id_info_stage FROM informations_stage WHERE num_etu = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->execute([$num_etu]);
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
            
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->execute([
                $entreprise,
                $date_debut,
                $date_fin,
                $sujet,
                $description,
                $encadrant,
                $email_encadrant,
                $telephone_encadrant,
                $num_etu
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
            
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->execute([
                $num_etu,
                $entreprise,
                $date_debut,
                $date_fin,
                $sujet,
                $description,
                $encadrant,
                $email_encadrant,
                $telephone_encadrant
            ]);
        }

        echo json_encode(['success' => true, 'message' => 'Informations du stage enregistrées avec succès']);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Récupérer les informations existantes
        $query = "SELECT * FROM informations_stage WHERE num_etu = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$num_etu]);
        $stage_info = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($stage_info) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'entreprise' => $stage_info['id_entreprise'],
                    'date_debut' => $stage_info['date_debut_stage'],
                    'date_fin' => $stage_info['date_fin_stage'],
                    'sujet' => $stage_info['sujet_stage'],
                    'description' => $stage_info['description_stage'],
                    'encadrant' => $stage_info['encadrant_entreprise'],
                    'email_encadrant' => $stage_info['email_encadrant'],
                    'telephone_encadrant' => $stage_info['telephone_encadrant']
                ]
            ]);
        } else {
            echo json_encode(['success' => true, 'data' => null]);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement des informations']);
} 