<?php
// Test du contrôleur via le système de routage
require_once __DIR__ . '/../../app/controllers/EvaluationDossiersController.php';

// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test du contrôleur EvaluationDossiersController</h2>";

try {
    // Créer une instance du contrôleur
    $controller = new EvaluationDossiersController();
    echo "<p>✅ Contrôleur créé avec succès</p>";
    
    // Tester la méthode index
    echo "<h3>Test de la méthode index :</h3>";
    $result = $controller->index();
    echo "<p>✅ Méthode index exécutée</p>";
    echo "<pre>" . print_r($result, true) . "</pre>";
    
    // Tester la connexion à la base de données
    echo "<h3>Test de la base de données :</h3>";
    $pdo = Database::getConnection();
    echo "<p>✅ Connexion à la base de données réussie</p>";
    
    // Vérifier les tables
    $tables = ['enseignants', 'personnel_admin', 'rapport_etudiants', 'valider'];
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM $table");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p>Table $table : " . $result['total'] . " enregistrements</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Erreur table $table : " . $e->getMessage() . "</p>";
        }
    }
    
    // Tester la fonction getEnseignantIdFromAdmin
    echo "<h3>Test de la fonction getEnseignantIdFromAdmin :</h3>";
    
    // Utiliser la réflexion pour accéder à la méthode privée
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('getEnseignantIdFromAdmin');
    $method->setAccessible(true);
    
    // Tester avec différents IDs
    $testIds = [1, 2, 999]; // 999 pour tester le fallback
    
    foreach ($testIds as $testId) {
        try {
            $enseignantId = $method->invoke($controller, $testId);
            echo "<p>ID Personnel Admin $testId → ID Enseignant: " . ($enseignantId ?: 'null') . "</p>";
        } catch (Exception $e) {
            echo "<p style='color: red;'>Erreur avec ID $testId: " . $e->getMessage() . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Exception : " . $e->getMessage() . "</p>";
    echo "<p>Fichier : " . $e->getFile() . "</p>";
    echo "<p>Ligne : " . $e->getLine() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
} catch (Error $e) {
    echo "<p style='color: red;'>❌ Erreur PHP : " . $e->getMessage() . "</p>";
    echo "<p>Fichier : " . $e->getFile() . "</p>";
    echo "<p>Ligne : " . $e->getLine() . "</p>";
}
?> 