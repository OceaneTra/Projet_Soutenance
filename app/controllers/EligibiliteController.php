<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EligibiliteController 
{
    protected $request;

    public function __construct()
    {
        $this->request = $_POST;
    }

    public function index()
    {
        include 'ressources/views/candidature_soutenance/simulateur_eligibilite.php';
    }

    public function verifierEligibilite()
    {
        // Récupérer les données du formulaire
        $data = [
            'nom_complet' => $this->request['nom_complet'],
            'numero_etudiant' => $this->request['numero_etudiant'],
            'formation' => $this->request['formation'],
            'promotion' => $this->request['promotion'],
            'rapport_stage' => $this->request['rapport_stage'],
            'fiche_evaluation' => $this->request['fiche_evaluation'],
            'soutenance_blanche' => $this->request['soutenance_blanche'],
            'memoire' => $this->request['memoire'],
            'commentaires' => $this->request['commentaires']
        ];

        // Vérifier les conditions d'éligibilité
        $eligibilite = $this->verifierConditions($data);

        // Envoyer les données à l'administration
        $this->notifierAdministration($data, $eligibilite);

        // Afficher le résultat
        include 'ressources/views/candidature_soutenance/resultat_eligibilite.php';
    }

    public function verifierConditions($data)
    {
        $conditions = [
            'rapport_stage' => $data['rapport_stage'] === 'oui',
            'fiche_evaluation' => $data['fiche_evaluation'] === 'oui',
            'soutenance_blanche' => $data['soutenance_blanche'] === 'oui',
            'memoire' => $data['memoire'] === 'oui'
        ];

        $totalConditions = count($conditions);
        $conditionsRemplies = count(array_filter($conditions));

        return [
            'conditions' => $conditions,
            'total' => $totalConditions,
            'remplies' => $conditionsRemplies,
            'pourcentage' => ($conditionsRemplies / $totalConditions) * 100
        ];
    }

    private function notifierAdministration($data, $eligibilite)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your-email@example.com';
            $mail->Password = 'your-password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinataires
            $mail->setFrom('system@example.com', 'Système de Soutenance');
            $mail->addAddress('admin@example.com');

            // Contenu
            $mail->isHTML(true);
            $mail->Subject = 'Nouvelle demande de vérification d\'éligibilité';

            $message = "Nouvelle demande de vérification d'éligibilité :<br><br>";
            $message .= "Étudiant : {$data['nom_complet']}<br>";
            $message .= "Numéro étudiant : {$data['numero_etudiant']}<br>";
            $message .= "Formation : {$data['formation']}<br>";
            $message .= "Promotion : {$data['promotion']}<br><br>";
            $message .= "Conditions remplies : {$eligibilite['remplies']}/{$eligibilite['total']}<br>";
            $message .= "Pourcentage d'éligibilité : {$eligibilite['pourcentage']}%<br><br>";
            $message .= "Commentaires : {$data['commentaires']}";

            $mail->Body = $message;
            $mail->send();
        } catch (Exception $e) {
            // Gérer l'erreur d'envoi d'email
            error_log("Erreur d'envoi d'email : {$mail->ErrorInfo}");
        }
    }
} 