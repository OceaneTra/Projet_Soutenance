<?php
    session_start();
    require_once '../config/bd.php';

    // pour codifier les grades 
    function genererCodeGrade($libelle) {
        $correspondances = [
            "assistant" => "ASS",
            "maitre-assistant" => "MA",
            "maitre de conferences" => "MCF",
            "professeur des universites" => "PU",
            "charge de cours" => "CC",
            "vacataire" => "VAC",
            "attache temporaire d'enseignement et de recherche" => "ATER",
            "docteur hdr" => "HDR"
        ];

        // Normalisation : minuscules + suppression accents
        $libelle = strtolower(trim($libelle));
        $libelle = str_replace(
            ["é", "è", "ê", "ë", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", "ç", "’", "'"],
            ["e", "e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "c", "", ""],
            $libelle
        );
        
        return $correspondances[$libelle] ?? null;
    }

    if(isset($_POST['lib_grade'])){
        $lib_grade = strtolower(trim($_POST['lib_grade']));
        $id_grade = genererCodeGrade($lib_grade);
        
        if($id_grade != null){
            $requete_insertion_grade = $pdo->prepare("INSERT INTO grade (id_grade, lib_grade) VALUES (?,?)");
            try{
                $requete_insertion_grade->execute([$id_grade, $lib_grade]);
                echo "<p>Grade ajouté avec succès.</p>";
            } catch(PDOException $e){
                echo "<p>Erreur : ". $e->getMessage() ."</p>";
            }
        } else {
            echo "<p>Le grade entré n'est pas reconnu.</p>";
        }
    }
?>

<?php include '../include/headerGeneraux.php' ?>
<!-- Contenu principal -->
<div class="content">
    <h1>Gestion des Grades</h1>

    <!-- Formulaire d'ajout -->
    <div class="form-container">
        <h2>Ajouter un nouveau grade</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="lib_grade">Grade</label>
                <input type="text" id="lib_grade" name="lib_grade">
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <!-- Tableau des grades -->
    <table>
        <thead>
            <tr>
                <th>Id_grade</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $stmt = $pdo->query("SELECT * FROM grade");
            foreach ($stmt as $row) {
                $id_grade = $row['id_grade'];
                $lib_grade = $row['lib_grade'];
                echo "<tr>
                        <td>{$id_grade}</td>
                        <td>{$lib_grade}</td>
                        <td></td>
                    </tr>";
            }
        ?>
        </tbody>
    </table>
</div>
</div>

<?php include '../include/foot.php' ?>
