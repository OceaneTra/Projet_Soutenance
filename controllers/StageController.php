<?php
require_once 'models/InfoStage.php';

class StageController {
    private $infoStageModel;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
        $this->infoStageModel = new InfoStage($db);
    }

    public function handleRequest() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'etudiant') {
            return [
                'success' => false,
                'message' => 'Accès non autorisé'
            ];
        }

        $num_etu = $_SESSION['user']['num_etu'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handlePostRequest($num_etu);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return $this->handleGetRequest($num_etu);
        }

        return [
            'success' => false,
            'message' => 'Méthode non supportée'
        ];
    }

    private function handlePostRequest($num_etu) {
        $data = [
            'num_etu' => $num_etu,
            'entreprise' => $_POST['entreprise'],
            'date_debut' => $_POST['date_debut'],
            'date_fin' => $_POST['date_fin'],
            'sujet' => $_POST['sujet'],
            'description' => $_POST['description'],
            'encadrant' => $_POST['encadrant'],
            'email_encadrant' => $_POST['email_encadrant'],
            'telephone_encadrant' => $_POST['telephone_encadrant']
        ];

        if ($this->infoStageModel->saveStageInfo($data)) {
            return [
                'success' => true,
                'message' => 'Les informations du stage ont été enregistrées avec succès !'
            ];
        }

        return [
            'success' => false,
            'message' => 'Une erreur est survenue lors de l\'enregistrement des informations.'
        ];
    }

    private function handleGetRequest($num_etu) {
        $stage_info = $this->infoStageModel->getStageInfo($num_etu);
        $entreprises = $this->infoStageModel->getEntreprises();

        return [
            'success' => true,
            'data' => [
                'stage_info' => $stage_info,
                'entreprises' => $entreprises
            ]
        ];
    }
} 