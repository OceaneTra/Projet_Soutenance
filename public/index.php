<?php
// Point d'entrée de l'application

// Démarrer la session
session_start();

// Inclusion de la configuration de la base de données
require_once "../app/config/database.php";

// Routage simple
$route = isset($_GET['route']) ? $_GET['route'] : 'admin/dashboard';

// Analyse de la route
$routes = [
    'admin/dashboard' => ['controller' => 'ParametresController', 'action' => 'dashboard'],
    'admin/parametres/annee-academique' => ['controller' => 'ParametresController', 'action' => 'anneeAcademique'],
    'admin/parametres/grade' => ['controller' => 'ParametresController', 'action' => 'grade'],
    'admin/parametres/fonction' => ['controller' => 'ParametresController', 'action' => 'fonction'],
];

// Récupération de la configuration de la route
$routeConfig = isset($routes[$route]) ? $routes[$route] : null;

if ($routeConfig) {
    $controllerName = $routeConfig['controller'];
    $actionName = $routeConfig['action'];

    // Inclusion du contrôleur
    require_once "../app/controllers/{$controllerName}.php";

    // Instanciation du contrôleur
    $controller = new $controllerName($pdo);

    // Appel de la méthode d'action
    $controller->$actionName();
} else {
    // Page non trouvée
    echo "<h1>Page non trouvée</h1>";
    echo "<p>La route demandée n'existe pas.</p>";
}