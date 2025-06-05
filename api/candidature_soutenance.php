<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

// Vérifier si l'utilisateur est connecté et est un étudiant
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'etudiant') {
    echo json_encode(['success' => false, 'message' => 'Accès non autorisé']);
    exit;
}

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'submit_candidature':
        // Vérifier si l'étudiant a déjà soumis une candidature en attente
        $stmt = $conn->prepare("SELECT id_candidature FROM candidature_soutenance WHERE num_etu = ? AND statut_candidature = 'En attente'");
        $stmt->execute([$_SESSION['user_id']]);
        
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Vous avez déjà une candidature en attente']);
            exit;
        }

        // Vérifier si l'étudiant a rempli les informations du stage
        $stmt = $conn->prepare("SELECT id_info_stage FROM informations_stage WHERE num_etu = ?");
        $stmt->execute([$_SESSION['user_id']]);
        
        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'message' => 'Vous devez d\'abord remplir les informations de votre stage']);
            exit;
        }

        // Insérer la nouvelle candidature
        try {
            $stmt = $conn->prepare("INSERT INTO candidature_soutenance (num_etu, date_candidature) VALUES (?, NOW())");
            $stmt->execute([$_SESSION['user_id']]);
            
            // Envoyer un email au responsable de la scolarité
            $stmt = $conn->prepare("
                SELECT e.email_etu, e.nom_etu, e.prenom_etu, pa.mail_pers_admin 
                FROM etudiants e 
                JOIN personnel_admin pa ON pa.fonction = 'Responsable de la scolarité'
                WHERE e.num_etu = ?
            ");
            $stmt->execute([$_SESSION['user_id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($data) {
                $to = $data['mail_pers_admin'];
                $subject = "Nouvelle candidature à la soutenance";
                $message = "Une nouvelle candidature à la soutenance a été soumise par {$data['prenom_etu']} {$data['nom_etu']}.\n";
                $message .= "Email de l'étudiant : {$data['email_etu']}\n";
                $headers = "From: noreply@votresite.com";
                
                mail($to, $subject, $message, $headers);
            }
            
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la soumission de la candidature']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Action non reconnue']);
        break;
} 