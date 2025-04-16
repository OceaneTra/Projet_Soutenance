<?php
    session_start();
    require_once '../config/bd.php';

    // pour codifier les fonctions 
    function genererCodeFonction($libelle) {
        $correspondances = [
            "responsable de filiere" => "RESP_FILIERE",
            "chef de departement" => "CHEF_DEP",
            "directeur de laboratoire" => "DIR_LABO",
            "doyen de faculte" => "DOYEN",
            "vice-doyen" => "V_DOYEN",
            "coordinateur pedagogique" => "COORD_PEDAGO",
            "responsable d'annee" => "RESP_ANNEE",
            "president de jury" => "PRES_JURY",
            "secretaire pedagogique" => "SECR_PEDAGO",
            "encadrant de memoire ou de these" => "ENCADREUR",
            "membre de commission pedagogique" => "MEMB_COM_PEDAGO",
            "responsable de stage" => "RESP_STAGE",
            "membre du conseil scientifique" => "MEMB_CONS_SCI",
            "responsable de la recherche" => "RESP_RECHERCHE",
            "responsable des relations internationales" => "RESP_REL_INT",
            "responsable de la scolarite" => "RESP_SCOLARITE",
            "directeur d'ufr ou de composante" => "DIR_UFR",
            "responsable qualite" => "RESP_QUALITE"
        ];
    
        // Normalisation (minuscules + suppression accents/apostrophes courbes)
    $libelle = strtolower(trim($libelle));
    $libelle = str_replace(["é", "è", "ê", "ë", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", "ç", "'", "'"], 
                        ["e", "e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "c", "'", "'"], 
                        $libelle);

    return $correspondances[$libelle] ?? null;
    }

    if(isset($_POST['lib_fonction'])){
        $lib_fonction = strtolower(trim($_POST['lib_fonction']));
        $id_fonction = genererCodeFonction($lib_fonction);
        
        if($id_fonction != null){
            $requete_insertion_grade = $pdo->prepare("INSERT INTO fonction (id_fonction, lib_fonction) VALUES (?,?)");
            try{
                $requete_insertion_grade->execute([$id_fonction,$lib_fonction]);
                echo "<p>C'est goooooood ! tchai gerer affichage la</p>";
            }catch(PDOException $e){
                echo "<p>Erreur :". $e->getMessage() ."</p>";
            }
        }else{
            echo "<p>Le grade entré n'est pas reconnu.</p>";
        }
    }
?>
        <?php include '../include/headerGeneraux.php' ?>
        <!-- Contenu principal -->
        <div class="content">
            <h1>Gestion des Fonctions</h1>

            <!-- Formulaire d'ajout -->
            <div class="form-container">
                <h2>Ajouter un nouveau grade</h2>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="lib_fonction">Fonction</label>
                        <input type="text" id="lib_fonction" name="lib_fonction">
                    </div>
                    <button type="submit">Ajouter</button>
                </form>
            </div>

            <!-- Tableau des années académiques -->
            <table>
                <thead>
                    <tr>
                        <th>Id_fonction</th>
                        <th>Fonction</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $stmt = $pdo->query("SELECT * FROM fonction");
                    foreach ($stmt as $row) {
                        $id_fonction = $row['id_fonction'];
                        $lib_fonction = $row['lib_fonction'];
                        echo "<tr>
                                <td>{$id_fonction}</td>
                                <td>{$lib_fonction}</td>
                                <td></td>
                            </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>

<?php include '../include/foot.php' ?>