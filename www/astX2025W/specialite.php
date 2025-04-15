<?php
    session_start();
    require_once '../config/bd.php';

    // pour codifier les grades 
    function genererCodeSpecialite($libelle) {
        $correspondances = [
            "informatique" => "INFO",
            "mathématiques" => "MATH",
            "physique" => "PHYS",
            "chimie" => "CHIM",
            "biologie" => "BIO",
            "sciences de la terre" => "TERRE",
            "sciences de l'environnement" => "ENV",
            "génie civil" => "GC",
            "génie électrique" => "GELEC",
            "génie mécanique" => "GMEC",
            "télécommunications" => "TELCO",
            "énergies renouvelables" => "ENR",
            "robotique" => "ROBO",
            "économie" => "ECO",
            "gestion" => "GEST",
            "comptabilité" => "COMPTA",
            "marketing" => "MARK",
            "ressources humaines" => "RH",
            "droit" => "DROIT",
            "sciences politiques" => "POL",
            "psychologie" => "PSY",
            "sociologie" => "SOCIO",
            "philosophie" => "PHILO",
            "histoire" => "HIST",
            "géographie" => "GEO",
            "communication" => "COM",
            "journalisme" => "JOUR",
            "lettres modernes" => "LETTMOD",
            "lettres classiques" => "LETTCLAS",
            "langues étrangères appliquées" => "LEA",
            "médecine" => "MED",
            "pharmacie" => "PHARMA",
            "odontologie" => "ODONTO",
            "infirmiers" => "INF",
            "sage-femme" => "SF",
            "kinésithérapie" => "KINE",
            "arts plastiques" => "ARTPLAS",
            "cinéma" => "CINE",
            "musique" => "MUS",
            "théâtre" => "THEA",
            "histoire de l'art" => "HISTART",
            "agronomie" => "AGRO",
            "agroéconomie" => "AGROECO",
            "zootechnie" => "ZOO",
            "agroforesterie" => "AGROFOR",
            "sciences du sol" => "SOL",
            "développement rural" => "DEVRUR",
            "gestion de l'eau" => "EAU"
        ];
    
        // Nettoyage du libellé entré
        $libelle = strtolower(trim($libelle));
        $libelle = str_replace(
            ["é", "è", "ê", "ë", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", "ç"],
            ["e", "e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "c"],
            $libelle
        );
    
        return $correspondances[$libelle] ?? null;
    }
    

    if(isset($_POST['lib_specialite'])) {
        $lib_specialite = strtolower(trim($_POST['lib_specialite']));
        $id_specialite = genererCodeSpecialite($lib_specialite);
    
        if($id_specialite !== null) {
            $requete = $pdo->prepare("INSERT INTO specialite (id_specialite, lib_specialite) VALUES (?, ?)");
            try {
                $requete->execute([$id_specialite, $lib_specialite]);
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
        <h2>Ajouter une nouvelle spécialité</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="lib_specialite">Spécialité</label>
                <input type="text" id="lib_specialite" name="lib_specialite">
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <!-- Tableau des grades -->
    <table>
        <thead>
            <tr>
                <th>Id_spécialité</th>
                <th>Spécialité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $stmt = $pdo->query("SELECT * FROM specialite");
            foreach ($stmt as $row) {
                $id_specialite = $row['id_specialite'];
                $lib_specialite = $row['lib_specialite'];
                echo "<tr>
                        <td>{$id_specialite}</td>
                        <td>{$lib_specialite}</td>
                        <td></td>
                    </tr>";
            }
        ?>
        </tbody>
    </table>
</div>
</div>

<?php include '../include/foot.php' ?>
