<?php

class AuditLog {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function log($userId, $action, $tableName, $recordId, $details = '') {
        $sql = "INSERT INTO pister (id_utilisateur, action, table_name, record_id, details, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId, $action, $tableName, $recordId, $details]);
    }

    public function getLogs($page = 1, $perPage = 20, $filters = []) {
        $offset = ($page - 1) * $perPage;
        $where = [];
        $params = [];

        // Construction de la clause WHERE en fonction des filtres
        if (!empty($filters['date_debut'])) {
            $where[] = "DATE(p.created_at) >= ?";
            $params[] = $filters['date_debut'];
        }
        if (!empty($filters['date_fin'])) {
            $where[] = "DATE(p.created_at) <= ?";
            $params[] = $filters['date_fin'];
        }
        if (!empty($filters['statut'])) {
            $where[] = "p.action = ?";
            $params[] = $filters['statut'];
        }
        if (!empty($filters['search'])) {
            $where[] = "(u.nom_utilisateur LIKE ? OR u.login_utilisateur LIKE ? OR p.details LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "SELECT p.*, u.nom_utilisateur, u.login_utilisateur 
                FROM pister p 
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur 
                $whereClause 
                ORDER BY p.created_at DESC 
                LIMIT ? OFFSET ?";

        $params[] = $perPage;
        $params[] = $offset;

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalLogs($filters = []) {
        $where = [];
        $params = [];

        // Construction de la clause WHERE en fonction des filtres
        if (!empty($filters['date_debut'])) {
            $where[] = "DATE(p.created_at) >= ?";
            $params[] = $filters['date_debut'];
        }
        if (!empty($filters['date_fin'])) {
            $where[] = "DATE(p.created_at) <= ?";
            $params[] = $filters['date_fin'];
        }
        if (!empty($filters['statut'])) {
            $where[] = "p.action = ?";
            $params[] = $filters['statut'];
        }
        if (!empty($filters['search'])) {
            $where[] = "(u.nom_utilisateur LIKE ? OR u.login_utilisateur LIKE ? OR p.details LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $whereClause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

        $sql = "SELECT COUNT(*) as total 
                FROM pister p 
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur 
                $whereClause";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getUserLogs($userId, $page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT p.*, u.nom_utilisateur, u.login_utilisateur 
                FROM pister p 
                LEFT JOIN utilisateurs u ON p.id_utilisateur = u.id_utilisateur 
                WHERE p.id_utilisateur = ? 
                ORDER BY p.created_at DESC 
                LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $perPage, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 