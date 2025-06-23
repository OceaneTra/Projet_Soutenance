<?php
// Configuration SMTP pour PHPMailer
return [
    'smtp' => [
        'host' => 'smtp.gmail.com', // Ou votre serveur SMTP
        'port' => 587,
        'encryption' => 'tls',
        'username' => 'managersoutenance@gmail.com', // À configurer avec votre email
        'password' => 'iweglnpanhpkoqfe', // À configurer avec votre mot de passe d'application
        'from_email' => 'managersoutenance@gmail.com',
        'from_name' => 'Soutenance Manager'
    ]
]; 