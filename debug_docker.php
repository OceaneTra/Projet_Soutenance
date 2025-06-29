<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h2>Debug avec Docker</h2>";

// Afficher les informations PHP
echo "<h3>Informations PHP :</h3>";
echo "<p>Version PHP : " . phpversion() . "</p>";
echo "<p>Fichier de log d'erreur : " . ini_get('error_log') . "</p>";

// Tester la connexion à la base de données
echo "<h3>Test de connexion à la base de données :</h3>";
try {
    require_once 'app/config/database.php';
    $pdo = Database::getConnection();
    echo "<p style='color: green;'>✅ Connexion à la base de données réussie</p>";
    
    // Tester une requête
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM enseignants");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Nombre d'enseignants : " . $result['total'] . "</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erreur de connexion : " . $e->getMessage() . "</p>";
}

// Tester le modèle Valider
echo "<h3>Test du modèle Valider :</h3>";
try {
    require_once 'app/models/Valider.php';
    
    // Lister les enseignants
    $stmt = $pdo->query("SELECT id_enseignant, nom_enseignant FROM enseignants LIMIT 3");
    $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>Enseignants disponibles :</p>";
    foreach ($enseignants as $enseignant) {
        echo "- ID: " . $enseignant['id_enseignant'] . ", Nom: " . $enseignant['nom_enseignant'] . "<br>";
    }
    
    // Lister les rapports
    $stmt = $pdo->query("SELECT id_rapport, nom_rapport FROM rapport_etudiants LIMIT 3");
    $rapports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p>Rapports disponibles :</p>";
    foreach ($rapports as $rapport) {
        echo "- ID: " . $rapport['id_rapport'] . ", Nom: " . $rapport['nom_rapport'] . "<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erreur modèle Valider : " . $e->getMessage() . "</p>";
}

// Afficher les logs récents
echo "<h3>Logs d'erreur récents :</h3>";
$logFile = ini_get('error_log');
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = array_slice(explode("\n", $logs), -20); // 20 dernières lignes
    echo "<pre style='background: #f5f5f5; padding: 10px; max-height: 300px; overflow-y: scroll;'>";
    foreach ($recentLogs as $log) {
        if (trim($log)) {
            echo htmlspecialchars($log) . "\n";
        }
    }
    echo "</pre>";
} else {
    echo "<p>Fichier de log non trouvé : $logFile</p>";
}
?> 