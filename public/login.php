<?php
session_start();
require_once __DIR__.'/../app/config/database.php';
require_once __DIR__.'/../app/controllers/AuthController.php';

    
    $authController = new AuthController(Database::getConnection());
    if ($authController->login($_POST['login'], $_POST['password'])) {
        header('Location: layout.php'); // Rediriger vers la page appropriée
        exit;
    } else {
        $_SESSION['error'] = 'Login ou mot de passe incorrect';
        header('Location: page_connexion.php');
        exit;
    }