<?php
class Database {
    private static $host = 'db'; // très important : utiliser le nom du service Docker
    private static $db   = 'soutenance_manager';
    private static $user = 'root';
    private static $pass = 'password'; // mot de passe défini dans docker-compose.yml
    private static $charset = 'utf8';

    public static function getConnection() {
        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            $pdo = new PDO($dsn, self::$user, self::$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}