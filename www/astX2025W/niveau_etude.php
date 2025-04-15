<?php
    session_start();
    require_once '../config/bd.php';

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $lib_niv_etude = trim($_POST['lib_niv_etude']);
        $libelle_niveau = explode(" ", $lib_niv_etude);

        if(count($libelle_niveau) === 2 ){
            $cycle = substr($libelle_niveau[0], 0, 1);
            $niveau = substr($libelle_niveau[1], 0, 1);
            
            $id_niv_etude = $cycle ."0". $niveau;

            $requete_insertion_niveau_etude = $pdo->prepare("INSERT INTO niveau_etude (id_niv_etude, lib_niv_etude) VALUES (?,?)");
            try{
                $requete_insertion_niveau_etude->execute([$id_niv_etude,$lib_niv_etude]);
                echo "<p>C'est goooooood ! tchai gerer affichage la</p>";
            }catch(PDOException $e){
                echo "<p>Erreur :". $e->getMessage() ."</p>";
            }
        }
    }
?>
        <?php include '../include/headerGeneraux.php' ?>
        <!-- Contenu principal -->
        <div class="content">
            <h1>Gestion des niveaux d'études</h1>

            <!-- Formulaire d'ajout -->
            <div class="form-container">
                <h2>Ajouter un niveaux d'études</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="lib_niv_etude">niveau d'etude</label>
                        <input type="text" id="lib_niv_etude" name="lib_niv_etude">
                    </div>
                    <button type="submit">Ajouter</button>
                </form>
            </div>

            <!-- Tableau des années académiques -->
            <table>
                <thead>
                    <tr>
                        <th>Id_Niveau</th>
                        <th>Niveau</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $stmt = $pdo->query("SELECT * FROM niveau_etude");
                    foreach ($stmt as $row) {
                        $id_niv_etude = $row['id_niv_etude'];
                        $lib_niv_etude = $row['lib_niv_etude'];
                        echo "<tr>
                                <td>{$id_niv_etude}</td>
                                <td>{$lib_niv_etude}</td>
                            </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include '../include/foot.php' ?>