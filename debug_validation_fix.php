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

echo "<h2>Diagnostic du problème de validation</h2>";

try {
    // Connexion directe
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>✅ Connexion réussie</h3>";
    
    // Vérifier la structure de la table valider
    echo "<h3>Structure de la table valider :</h3>";
    $stmt = $pdo->query("DESCRIBE valider");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>Champ</th><th>Type</th><th>Null</th><th>Clé</th><th>Défaut</th></tr>";
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . $column['Field'] . "</td>";
        echo "<td>" . $column['Type'] . "</td>";
        echo "<td>" . $column['Null'] . "</td>";
        echo "<td>" . $column['Key'] . "</td>";
        echo "<td>" . $column['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Lister les enseignants
    echo "<h3>Enseignants disponibles :</h3>";
    $stmt = $pdo->query("SELECT id_enseignant, nom_enseignant, prenom_enseignant FROM enseignants ORDER BY id_enseignant");
    $enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th></tr>";
    foreach ($enseignants as $enseignant) {
        echo "<tr>";
        echo "<td>" . $enseignant['id_enseignant'] . "</td>";
        echo "<td>" . $enseignant['nom_enseignant'] . "</td>";
        echo "<td>" . $enseignant['prenom_enseignant'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Lister les rapports
    echo "<h3>Rapports disponibles :</h3>";
    $stmt = $pdo->query("SELECT id_rapport, nom_rapport, etape_validation FROM rapport_etudiants ORDER BY id_rapport");
    $rapports = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Étape</th></tr>";
    foreach ($rapports as $rapport) {
        echo "<tr>";
        echo "<td>" . $rapport['id_rapport'] . "</td>";
        echo "<td>" . $rapport['nom_rapport'] . "</td>";
        echo "<td>" . $rapport['etape_validation'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>Erreur :</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?> 