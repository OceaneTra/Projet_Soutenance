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

    // Gestion des années académiques
    public function anneeAcademique() {
        $message = $_SESSION['message'] ?? ''; // Récupérer les messages flash
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['message'], $_SESSION['error']); // Effacer après affichage
       
        $action = $_GET['sub_action'] ?? 'list'; // 'list', 'add', 'edit', 'delete', 'delete_multiple'
        $id_annee_acad = $_GET['id_annee_acad'] ?? null;
        $annee_a_modifier = null;

        // Traitement des soumissions de formulaire POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['submit_add_annee'])) { // Ajout
                $date_deb = $_POST["date_deb"] ?? '';
                $date_fin = $_POST["date_fin"] ?? '';

            if (!empty($date_deb) && !empty($date_fin)) {
                    if (strtotime($date_fin) > strtotime($date_deb)) {
                $result = $this->anneeAcademique->addAnneeAcademique($date_deb, $date_fin);
                if ($result) {
                            $_SESSION['message'] = "L'année académique a été ajoutée avec succès.";
                } else {
                            $_SESSION['error'] = "Une erreur s'est produite lors de l'ajout de l'année académique (ID potentiellement dupliqué ou autre erreur BDD).";
                }
            } else {
                        $_SESSION['error'] = "La date de fin doit être postérieure à la date de début.";
            }
                } else {
                    $_SESSION['error'] = "Veuillez remplir tous les champs.";
            }
                // Rediriger pour éviter la resoumission du formulaire (Post-Redirect-Get pattern)
                header("Location: ?page=parametres_generaux&action=annees_academiques");
                exit;

            } elseif (isset($_POST['submit_edit_annee'])) { // Modification
                $id_annee_acad_edit = $_POST['id_annee_acad_edit'] ?? null;
                $date_deb = $_POST["date_deb_edit"] ?? '';
                $date_fin = $_POST["date_fin_edit"] ?? '';

                if ($id_annee_acad_edit && !empty($date_deb) && !empty($date_fin)) {
                     if (strtotime($date_fin) > strtotime($date_deb)) {
                        $result = $this->anneeAcademique->updateAnneeAcademique($id_annee_acad_edit, $date_deb, $date_fin);
                if ($result) {
                            $_SESSION['message'] = "L'année académique a été modifiée avec succès.";
                } else {
                            $_SESSION['error'] = "Une erreur s'est produite lors de la modification.";
                }
            } else {
                        $_SESSION['error'] = "La date de fin doit être postérieure à la date de début.";
            }
                } else {
                    $_SESSION['error'] = "Données de modification invalides ou manquantes.";
        }
                header("Location: ?page=parametres_generaux&action=annees_academiques");
                exit;

            } elseif (isset($_POST['submit_delete_multiple'])) { // Suppression multiple
                $ids_a_supprimer = $_POST['selected_ids'] ?? [];
                if (!empty($ids_a_supprimer)) {
                    $succes_count = 0;
                    $erreur_count = 0;
                    foreach ($ids_a_supprimer as $id) {
                        if ($this->anneeAcademique->deleteAnneeAcademique($id)) {
                            $succes_count++;
                        } else {
                            $erreur_count++;
    }
}
                    if ($succes_count > 0) {
                        $_SESSION['message'] = "$succes_count année(s) académique(s) supprimée(s) avec succès.";
                    }
                    if ($erreur_count > 0) {
                        $_SESSION['error'] = "$erreur_count suppression(s) ont échoué (peut-être utilisées ailleurs).";
                    }
                } else {
                    $_SESSION['error'] = "Aucune année académique sélectionnée pour la suppression.";
                }
                header("Location: ?page=parametres_generaux&action=annees_academiques");
                exit;
            }
        }

        // Logique pour les actions GET (comme afficher le formulaire d'édition ou supprimer un seul élément)
        if ($action === 'edit' && $id_annee_acad) {
            $annee_a_modifier = $this->anneeAcademique->getAnneeAcademiqueById($id_annee_acad);
            if (!$annee_a_modifier) {
                $_SESSION['error'] = "Année académique non trouvée pour modification.";
                header("Location: ?page=parametres_generaux&action=annees_academiques");
                exit;
            }
            // Le formulaire d'édition sera affiché dans la vue annees_academiques.php
            // ou vous pourriez avoir une vue séparée 'edit_annee_academique.php'
        } elseif ($action === 'delete' && $id_annee_acad) { // Suppression simple (si vous l'implémentez)
            if ($this->anneeAcademique->deleteAnneeAcademique($id_annee_acad)) {
                $_SESSION['message'] = "L'année académique a été supprimée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression (peut-être utilisée ailleurs).";
            }
            header("Location: ?page=parametres_generaux&action=annees_academiques");
            exit;
        }

        // Récupérer toutes les années pour l'affichage de la liste
        $annees = $this->anneeAcademique->getAllAnneeAcademiques();

       
        include __DIR__ . '/../../ressources/views/admin/partials/parametres_generaux/annees_academiques.php';
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