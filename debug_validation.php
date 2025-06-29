<?php
// Configuration temporaire pour le diagnostic
$host = 'localhost';
$db   = 'soutenance_manager';
$user = 'root';
$pass = ''; // Laissez vide si pas de mot de passe
$charset = 'utf8';

// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Diagnostic de la table valider</h2>";

try {
    // Connexion directe
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Vérifier la structure de la table valider
    echo "<h3>Structure de la table valider :</h3>";
    $stmt = $pdo->query("DESCRIBE valider");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>Champ</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th><th>Extra</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "<td>" . $column['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Vérifier si le champ decision_validation existe
    $hasDecisionField = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'decision_validation') {
            $hasDecisionField = true;
            break;
        }
    }
    
    if (!$hasDecisionField) {
        echo "<h3 style='color: red;'>ERREUR : Le champ decision_validation n'existe pas !</h3>";
        echo "<p>Il faut d'abord ajouter le champ à la table valider.</p>";
        
        // Proposer la requête SQL
        echo "<h3>Requête SQL à exécuter :</h3>";
        echo "<pre>";
        echo "ALTER TABLE valider ADD COLUMN decision_validation ENUM('valider', 'rejeter') NOT NULL DEFAULT 'valider' AFTER commentaire_validation;";
        echo "</pre>";
        
        // Essayer d'exécuter la requête automatiquement
        echo "<h3>Tentative d'ajout automatique du champ :</h3>";
        try {
            $stmt = $pdo->prepare("ALTER TABLE valider ADD COLUMN decision_validation ENUM('valider', 'rejeter') NOT NULL DEFAULT 'valider' AFTER commentaire_validation");
            $stmt->execute();
            echo "<p style='color: green;'>✅ Champ decision_validation ajouté avec succès !</p>";
            $hasDecisionField = true;
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Erreur lors de l'ajout du champ : " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<h3 style='color: green;'>✅ Le champ decision_validation existe</h3>";
    }
    
    // Tester l'insertion
    if ($hasDecisionField) {
        echo "<h3>Test d'insertion :</h3>";
        try {
            $stmt = $pdo->prepare("INSERT INTO valider (id_enseignant, id_rapport, date_validation, commentaire_validation, decision_validation) VALUES (?, ?, NOW(), ?, ?)");
            $result = $stmt->execute([1, 2, 'Test de validation', 'valider']);
            if ($result) {
                echo "<p style='color: green;'>✅ Insertion réussie</p>";
            } else {
                echo "<p style='color: red;'>❌ Échec de l'insertion</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Erreur lors de l'insertion : " . $e->getMessage() . "</p>";
        }
    }
    
    // Vérifier les données existantes
    echo "<h3>Données existantes dans la table valider :</h3>";
    $stmt = $pdo->query("SELECT * FROM valider LIMIT 5");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($data)) {
        echo "<p>Aucune donnée dans la table valider</p>";
    } else {
        echo "<table border='1'>";
        echo "<tr>";
        foreach (array_keys($data[0]) as $key) {
            echo "<th>" . $key . "</th>";
        }
        echo "</tr>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>Erreur de connexion :</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?> 