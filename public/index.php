<?php
// Point d'entrée de l'application

// Démarrer la session
session_start();

// Inclure la configuration de la base de données
require_once '../app/config/database.php';

// Établir la connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test de connexion
    $testStmt = $pdo->query("SELECT 1");
    // Si on arrive ici, la connexion fonctionne
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Inclure le contrôleur et le modèle AnneeAcademique
require_once '../app/controllers/DashboardController.php';

// Créer une instance du contrôleur
$dashboardController = new DashboardController($pdo);


// Gérer les requêtes GET et POST via le paramètre route
if (isset($_GET['route'])) {
    $route = $_GET['route'];

    // Routes pour le dashboard
    if ($route === 'admin/dashboard') {
        $dashboardController->index();
    }

    else {
        // Page 404 si la route n'est pas reconnue
        header('HTTP/1.0 404 Not Found');
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>404 - Page non trouvée</title>
            <link rel="stylesheet" href="/assets/css/output_dashboard_admin.css">
            <link rel="stylesheet" href="/assets/css/main.css">
        </head>
        <body class="bg-gray-100 flex items-center justify-center h-screen">
            <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
                <h1 class="text-4xl font-bold text-red-500 mb-4">404</h1>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Page non trouvée</h2>
                <p class="text-gray-600 mb-6">La page que vous recherchez n\'existe pas ou a été déplacée.</p>
                <a href="?route=admin/dashboard" class="inline-block bg-green-500 text-white px-6 py-2 rounded-md hover:bg-green-600 transition-colors">
                    Retour à l\'accueil
                </a>
            </div>
        </body>
        </html>';
        exit;
    }
} else {
    // Redirection vers le dashboard par défaut si aucune route n'est spécifiée
    header('Location: ?route=admin/dashboard');
    exit;
}