<?php
require_once __DIR__ . '/../models/AnneeAcademique.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Fonction.php';

class ParametresController {
    private $pdo;
    private $anneeAcademique;
    private $grade;
    private $fonction;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->anneeAcademique = new AnneeAcademique($pdo);
        $this->grade = new Grade($pdo);
        $this->fonction = new Fonction($pdo);
    }

    // Affiche le tableau de bord des paramètres
    public function dashboard() {
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/dashboard.php';
    }

    // Gestion des années académiques
    public function anneeAcademique() {
        $message = '';
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $date_deb = $_POST["date_deb"];
            $date_fin = $_POST["date_fin"];

            if (!empty($date_deb) && !empty($date_fin)) {
                $result = $this->anneeAcademique->addAnneeAcademique($date_deb, $date_fin);

                if ($result) {
                    $message = "L'année académique a été ajoutée avec succès.";
                } else {
                    $error = "Une erreur s'est produite lors de l'ajout de l'année académique.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        $annees = $this->anneeAcademique->getAllAnneeAcademiques();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/annee_academique.php';
    }

    // Gestion des grades
    public function grade() {
        $message = '';
        $error = '';

        if (isset($_POST['lib_grade'])) {
            $lib_grade = $_POST['lib_grade'];

            if (!empty($lib_grade)) {
                $result = $this->grade->addGrade($lib_grade);

                if ($result) {
                    $message = "Le grade a été ajouté avec succès.";
                } else {
                    $error = "Le grade entré n'est pas reconnu.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        $grades = $this->grade->getAllGrades();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/grade.php';
    }

    // Gestion des fonctions
    public function fonction() {
        $message = '';
        $error = '';

        if (isset($_POST['lib_fonction'])) {
            $lib_fonction = $_POST['lib_fonction'];

            if (!empty($lib_fonction)) {
                $result = $this->fonction->addFonction($lib_fonction);

                if ($result) {
                    $message = "La fonction a été ajoutée avec succès.";
                } else {
                    $error = "La fonction entrée n'est pas reconnue.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        $fonctions = $this->fonction->getAllFonctions();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/fonction.php';
    }
}