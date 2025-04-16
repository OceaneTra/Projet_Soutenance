<?php
    session_start();
   require_once '../config/bd.php';

    // pour codifier les grades 
    function genererCodeTypeUtilisateur($libelle) {
        $correspondances = [
            "administrateur systeme" => "ADMIN",
            "directeur de laboratoire" => "DIRLAB",
            "enseignant" => "ENS",
            "personnel administratif" => "PA",
            "etudiant" => "ETU",
            "technicien" => "TECH",
            "secretaire pedagogique" => "SECPED",
            "responsable pedagogique" => "RESPED",
            "superviseur" => "SUPERV",
            "chercheur" => "CHERCH"
        ];
    
        $libelle = strtolower(trim($libelle));
        $libelle = str_replace(
            ["é", "è", "ê", "ë", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", "ç"],
            ["e", "e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "c"],
            $libelle
        );
    
        return $correspondances[$libelle] ?? null;
    }
    
    

    if(isset($_POST['lib_type_utilisateur'])) {
        $lib_type_utilisateur = strtolower(trim($_POST['lib_type_utilisateur']));
        $id_type_utilisateur = genererCodeTypeUtilisateur($lib_type_utilisateur);
    
        if($id_type_utilisateur !== null) {
            $requete = $pdo->prepare("INSERT INTO type_utilisateur (id_type_utilisateur, lib_type_utilisateur) VALUES (?, ?)");
            try {
                $requete->execute([$id_type_utilisateur, $lib_type_utilisateur]);
                echo "<p>Spécialité ajoutée avec succès.</p>";
            } catch(PDOException $e) {
                echo "<p>Erreur : " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>Spécialité non reconnue.</p>";
        }
    }

?>

<?php include '../include/headerGeneraux.php' ?>
<!-- Contenu principal -->
<div class="content">
    <h1>Gestion des Grades</h1>

    <!-- Formulaire d'ajout -->
    <div class="form-container">
        <h2>Ajouter un nouveau type utilisateur</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="lib_type_utilisateur">type utilisateur</label>
                <input type="text" id="lib_type_utilisateur" name="lib_type_utilisateur">
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <!-- Tableau des grades -->
    <table>
        <thead>
            <tr>
                <th>id_type_utilisateur</th>
                <th>Type Utilisateur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM type_utilisateur");
            foreach ($stmt as $row) {
                $id_type_utilisateur = $row['id_type_utilisateur'];
                $lib_type_utilisateur = $row['lib_type_utilisateur'];
                echo "<tr>
                        <td>{$id_type_utilisateur}</td>
                        <td>{$lib_type_utilisateur}</td>
                        <td></td>
                    </tr>";
            }
        ?>
        </tbody>
    </table>
</div>
</div>

<?php include '../include/foot.php' ?>