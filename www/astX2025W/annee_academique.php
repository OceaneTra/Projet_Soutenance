<?php
    session_start();
    require_once '../config/bd.php';

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $date_deb = $_POST["date_deb"];
        $date_fin = $_POST["date_fin"];

        // recuperation des année
        $annee1 = date("Y", strtotime($date_deb));
        $annee2 = date("Y", strtotime($date_fin));

        $id_annee_acad = substr($annee2, 0, 1) . substr($annee1, 2,2) . substr($annee2, 2, 2);

        $requete_insertion_anneeAcademique = $pdo->prepare("INSERT INTO annee_academique (id_annee_acad, date_deb, date_fin) VALUES (?,?,?)");
        try{
            $requete_insertion_anneeAcademique->execute([$id_annee_acad,$date_deb,$date_fin]);
            echo "<p>C'est goooooood ! tchai gerer affichage la</p>";
        }catch(PDOException $e){
            echo "<p>Erreur :". $e->getMessage() ."</p>";
        }
    }
?>
        <?php include '../include/headerGeneraux.php' ?>
        <!-- Contenu principal -->
        <div class="content">
            <h1>Gestion des Années Académiques</h1>

            <!-- Formulaire d'ajout -->
            <div class="form-container">
                <h2>Ajouter une année académique</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="date_deb">Date début</label>
                        <input type="date" id="date_deb" name="date_deb">

                        <label for="date_fin">Date fin</label>
                        <input type="date" id="date_fin" name="date_fin">
                    </div>
                    <button type="submit">Ajouter</button>
                </form>
            </div>

            <!-- Tableau des années académiques -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Année académique</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $stmt = $pdo->query("SELECT * FROM annee_academique ORDER BY date_deb DESC");
                    foreach ($stmt as $row) {
                        $id_annee_acad = $row['id_annee_acad'];
                        $annee_deb = date('Y', strtotime($row['date_deb']));
                        $annee_fin = date('Y', strtotime($row['date_fin']));
                        echo "<tr>
                                <td>{$id_annee_acad}</td>
                                <td>{$annee_deb}-{$annee_fin}</td>
                                <td>
                                    <button>Modifier</button>
                                    <button>Supprimer</button>
                                </td>
                            </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include '../include/foot.php' ?>