<?php
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
require_once '../app/models/AnneeAcademique.php';

// Créer une instance du contrôleur
$dashboardController = new DashboardController($pdo);
// Créer une instance du modèle AnneeAcademique pour un accès direct si nécessaire
$anneeAcademique = new AnneeAcademique($pdo);

// Gérer les requêtes GET et POST via le paramètre route
if (isset($_GET['route'])) {
    $route = $_GET['route'];

    // Routes pour le dashboard
    if ($route === 'admin/dashboard') {
        $dashboardController->index();
    }
    // Routes pour l'année académique
    else if ($route === 'admin/parametres/annee-academique') {
        // Si c'est une requête POST, c'est un ajout d'année académique
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Traitement du formulaire
            $dateDebut = $_POST['date_deb'] ?? '';
            $dateFin = $_POST['date_fin'] ?? '';

            // Validation des données
            if (empty($dateDebut) || empty($dateFin)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
            } else {
                // Utiliser l'instance du modèle AnneeAcademique créée ci-dessus
                $result = $anneeAcademique->addAnneeAcademique($dateDebut, $dateFin);

                if ($result) {
                    $_SESSION['success'] = "Année académique ajoutée avec succès.";
                } else {
                    $_SESSION['error'] = "Erreur lors de l'ajout de l'année académique.";
                }
            }

            // Redirection vers la page des années académiques
            header('Location: ?route=admin/dashboard&section=Gparam&modal=annee-academique');
            exit;
        }

        // Sinon, c'est juste l'affichage de la page
        $dashboardController->anneeAcademique();
    }
    // Autres routes...
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