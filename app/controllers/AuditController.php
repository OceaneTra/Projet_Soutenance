<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AuditLog.php';

class AuditController {
    private $db;
    private $auditLog;
    private $viewPath;

    public function __construct($db) {
        $this->db = $db;
        $this->auditLog = new AuditLog($db);
        $this->viewPath = __DIR__ . '/../../ressources/views/';
    }

    public function index() {
        // Récupération des paramètres de pagination et de filtrage
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 20;

        // Récupération des filtres
        $filters = [
            'date_debut' => $_GET['date_debut'] ?? null,
            'date_fin' => $_GET['date_fin'] ?? null,
            'statut' => $_GET['statut'] ?? null,
            'search' => $_GET['search'] ?? null
        ];

        // Récupération des logs avec pagination
        $logs = $this->auditLog->getLogs($page, $perPage, $filters);
        $totalLogs = $this->auditLog->getTotalLogs($filters);
        $totalPages = ceil($totalLogs / $perPage);

        // Passage des données à la vue
        $data = [
            'logs' => $logs,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalLogs' => $totalLogs,
            'filters' => $filters
        ];

        // Inclusion de la vue
        require_once $this->viewPath . 'piste_audit_content.php';
    }

    public function userLogs($userId) {
        // Récupération des paramètres de pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 20;

        // Récupération des logs de l'utilisateur
        $logs = $this->auditLog->getUserLogs($userId, $page, $perPage);
        $totalLogs = $this->auditLog->getTotalLogs(['user_id' => $userId]);
        $totalPages = ceil($totalLogs / $perPage);

        // Passage des données à la vue
        $data = [
            'logs' => $logs,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalLogs' => $totalLogs,
            'userId' => $userId
        ];

        
    }
} 