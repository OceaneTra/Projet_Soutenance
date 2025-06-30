<?php
require_once __DIR__ . '/../config/database.php';

class SauvegardeRestaurationController {
    private $backupDir;

    public function __construct() {
        $this->backupDir = __DIR__ . '/../../ressources/uploads/backups/';
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0777, true);
        }
    }

    // Affiche la page principale avec la liste des sauvegardes
    public function index() {
        $backups = $this->getBackups();
        require __DIR__ . '/../../ressources/views/sauvegarde_restauration_content.php';
    }

    // Lance une sauvegarde manuelle
    public function createBackup() {
        $backupName = isset($_POST['backup_name']) && $_POST['backup_name'] ? preg_replace('/[^a-zA-Z0-9_-]/', '_', $_POST['backup_name']) : 'backup_' . date('Ymd_His');
        $filename = $backupName . '_' . date('Ymd_His') . '.sql';
        $filepath = $this->backupDir . $filename;
        $dbConfig = $this->getDbConfig();
        $cmd = sprintf('mysqldump -h%s -u%s -p%s %s > %s',
            escapeshellarg($dbConfig['host']),
            escapeshellarg($dbConfig['user']),
            escapeshellarg($dbConfig['pass']),
            escapeshellarg($dbConfig['db']),
            escapeshellarg($filepath)
        );
        system($cmd, $retval);
        if ($retval === 0) {
            header('Location: /sauvegarde-restauration?success=1');
        } else {
            header('Location: /sauvegarde-restauration?error=1');
        }
        exit;
    }

    // Restaure la base à partir d'un fichier existant
    public function restoreBackup() {
        if (!isset($_POST['filename'])) {
            header('Location: /sauvegarde-restauration?error=1');
            exit;
        }
        $filename = basename($_POST['filename']);
        $filepath = $this->backupDir . $filename;
        if (!file_exists($filepath)) {
            header('Location: /sauvegarde-restauration?error=1');
            exit;
        }
        $dbConfig = $this->getDbConfig();
        $cmd = sprintf('mysql -h%s -u%s -p%s %s < %s',
            escapeshellarg($dbConfig['host']),
            escapeshellarg($dbConfig['user']),
            escapeshellarg($dbConfig['pass']),
            escapeshellarg($dbConfig['db']),
            escapeshellarg($filepath)
        );
        system($cmd, $retval);
        if ($retval === 0) {
            header('Location: /sauvegarde-restauration?restored=1');
        } else {
            header('Location: /sauvegarde-restauration?error=1');
        }
        exit;
    }

    // Restaure à partir d'un fichier uploadé
    public function uploadAndRestore() {
        if (!isset($_FILES['backup_file_upload']) || $_FILES['backup_file_upload']['error'] !== UPLOAD_ERR_OK) {
            header('Location: /sauvegarde-restauration?error=1');
            exit;
        }
        $tmp = $_FILES['backup_file_upload']['tmp_name'];
        $name = basename($_FILES['backup_file_upload']['name']);
        $dest = $this->backupDir . $name;
        move_uploaded_file($tmp, $dest);
        $_POST['filename'] = $name;
        $this->restoreBackup();
    }

    // Supprime une sauvegarde
    public function deleteBackup() {
        if (!isset($_POST['filename'])) {
            header('Location: /sauvegarde-restauration?error=1');
            exit;
        }
        $filename = basename($_POST['filename']);
        $filepath = $this->backupDir . $filename;
        if (file_exists($filepath)) {
            unlink($filepath);
            header('Location: /sauvegarde-restauration?deleted=1');
        } else {
            header('Location: /sauvegarde-restauration?error=1');
        }
        exit;
    }

    // Télécharge une sauvegarde
    public function downloadBackup() {
        if (!isset($_GET['filename'])) {
            header('Location: /sauvegarde-restauration?error=1');
            exit;
        }
        $filename = basename($_GET['filename']);
        $filepath = $this->backupDir . $filename;
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            header('Location: /sauvegarde-restauration?error=1');
            exit;
        }
    }

    // Liste les sauvegardes existantes
    private function getBackups() {
        $files = glob($this->backupDir . '*.sql');
        $backups = [];
        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => $this->humanFileSize(filesize($file)),
                'created_at' => date('Y-m-d H:i:s', filemtime($file)),
                'type' => 'Manuelle',
            ];
        }
        usort($backups, function($a, $b) { return strcmp($b['created_at'], $a['created_at']); });
        return $backups;
    }

    private function humanFileSize($size, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $unit = 0;
        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }
        return round($size, $precision) . ' ' . $units[$unit];
    }

    private function getDbConfig() {
        $ref = new ReflectionClass('Database');
        return [
            'host' => $ref->getProperty('host')->setAccessible(true) ? $ref->getProperty('host')->getValue() : 'db',
            'db'   => $ref->getProperty('db')->setAccessible(true) ? $ref->getProperty('db')->getValue() : 'soutenance_manager',
            'user' => $ref->getProperty('user')->setAccessible(true) ? $ref->getProperty('user')->getValue() : 'root',
            'pass' => $ref->getProperty('pass')->setAccessible(true) ? $ref->getProperty('pass')->getValue() : 'password',
        ];
    }
} 