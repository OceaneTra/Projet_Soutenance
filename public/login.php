<?php
session_start();
require_once __DIR__.'/../app/config/database.php';
require_once __DIR__.'/../app/controllers/AuthController.php';

// Vérifier le token CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        die('Erreur de sécurité CSRF');
    }
    
    $authController = new AuthController(Database::getConnection());
    if ($authController->login($_POST['login'], $_POST['password'])) {
        header('Location: layout_admin.php'); // Rediriger vers la page appropriée
        exit;
    } else {
        $_SESSION['error'] = 'Identifiants incorrects';
        header('Location: page_connexion.php');
        exit;
    }
}