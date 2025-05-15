<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Etudiants.php";

class GestionEtudiantController
{
    private $etudiant;
    private $baseViewPath;

    public function __construct()
    {
        echo "DEBUG CONTROLLER: Constructor called<br>";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->baseViewPath = __DIR__ . '/../../ressources/views/admin/';
        echo "DEBUG CONTROLLER: Base view path: " . $this->baseViewPath . "<br>";

        try {
            $db = Database::getConnection();
            if (!$db) {
                die("ERROR: Database connection failed");
            }
            echo "DEBUG CONTROLLER: Database connected<br>";

            $this->etudiant = new Etudiants($db);
            echo "DEBUG CONTROLLER: Etudiants model created<br>";
        } catch (Exception $e) {
            die("ERROR: " . $e->getMessage());
        }
    }

    // Afficher la liste des étudiants
    public function index()
    {
        echo "DEBUG INDEX: Method called!<br>";

        // Debug pour voir si on arrive ici
        error_log("DEBUG INDEX: Method called!");

        // Test simple avec données en dur
        $listeEtudiants = [];

        try {
            echo "DEBUG INDEX: About to get students<br>";
            $listeEtudiants = $this->etudiant->getAllEtudiant();
            echo "DEBUG INDEX: Got " . count($listeEtudiants) . " students<br>";
        } catch (Exception $e) {
            echo "ERROR INDEX: " . $e->getMessage() . "<br>";
        }

        // Gérer les actions POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "DEBUG INDEX: POST method detected<br>";
            // ... reste du code POST ...
        } else {
            echo "DEBUG INDEX: GET method<br>";
        }

        // Debug avant l'include
        echo "DEBUG INDEX: Before include, listeEtudiants = " . count($listeEtudiants) . "<br>";
        echo "DEBUG INDEX: View path = " . $this->baseViewPath . 'gestion_etudiants_content.php' . "<br>";

        // Vérifier que le fichier existe
        $viewPath = $this->baseViewPath . 'gestion_etudiants_content.php';
        if (!file_exists($viewPath)) {
            die("ERROR: View file not found at: " . $viewPath);
        }

        // Inclure la vue
        include $viewPath;

        echo "DEBUG INDEX: After include<br>";
    }

    // Ajouter un nouvel étudiant
    private function ajouterEtudiant()
    {
        try {
            // Récupérer les données du formulaire
            $num_etu = trim($_POST['num_etu']);
            $login_etu = trim($_POST['login_etu']);
            $nom_etu = trim($_POST['nom_etu']);
            $prenom_etu = trim($_POST['prenom_etu']);
            $date_naiss_etu = $_POST['date_naiss_etu'];
            $genre_etu = $_POST['genre_etu'];

            // Validation des données
            if (empty($num_etu) || empty($login_etu) || empty($nom_etu) || empty($prenom_etu)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                return;
            }

            // Vérifier si le numéro étudiant existe déjà
            if ($this->etudiant->getEtudiantById($num_etu)) {
                $_SESSION['error'] = "Ce numéro d'étudiant existe déjà.";
                return;
            }

            // Ajouter l'étudiant dans la base de données (avec mdp par défaut)
            $result = $this->etudiant->ajouterEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $login_etu);

            if ($result) {
                $_SESSION['success'] = "Étudiant ajouté avec succès.";
                header("Location: ?page=gestion_etudiants");
                exit();
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'étudiant.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur : " . $e->getMessage();
        }
    }

    // Modifier un étudiant existant
    private function modifierEtudiant()
    {
        try {
            // Récupérer d'abord l'ID depuis le champ caché
            $num_etu = isset($_POST['userId']) ? trim($_POST['userId']) : null;

            // Si pas d'ID, on ne peut pas modifier
            if (!$num_etu) {
                $_SESSION['error'] = "Impossible de modifier : ID manquant.";
                return;
            }

            $login_etu = trim($_POST['login_etu']);
            $nom_etu = trim($_POST['nom_etu']);
            $prenom_etu = trim($_POST['prenom_etu']);
            $date_naiss_etu = $_POST['date_naiss_etu'];
            $genre_etu = $_POST['genre_etu'];

            // Validation des données
            if (empty($login_etu) || empty($nom_etu) || empty($prenom_etu)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                return;
            }

            // Récupérer le mot de passe actuel de l'étudiant
            $etudiantActuel = $this->etudiant->getEtudiantById($num_etu);
            if (!$etudiantActuel) {
                $_SESSION['error'] = "Étudiant introuvable.";
                return;
            }

            $mdp_etu = $etudiantActuel->mdp_etu;

            // Mettre à jour l'étudiant
            $result = $this->etudiant->updateEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $login_etu, $mdp_etu);

            if ($result) {
                $_SESSION['success'] = "Étudiant modifié avec succès.";
                header("Location: ?page=gestion_etudiants");
                exit();
            } else {
                $_SESSION['error'] = "Erreur lors de la modification de l'étudiant.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur : " . $e->getMessage();
        }
    }

    // Supprimer un ou plusieurs étudiants
    private function supprimerEtudiants()
    {
        try {
            if (isset($_POST['selected_ids']) && is_array($_POST['selected_ids'])) {
                $num_etudiants = $_POST['selected_ids'];

                if (empty($num_etudiants)) {
                    $_SESSION['error'] = "Aucun étudiant sélectionné.";
                    return;
                }

                $success = 0;
                foreach ($num_etudiants as $num_etu) {
                    if ($this->etudiant->deleteEtudiant($num_etu)) {
                        $success++;
                    }
                }

                if ($success > 0) {
                    $_SESSION['success'] = "$success étudiant(s) supprimé(s) avec succès.";
                    header("Location: ?page=gestion_etudiants");
                    exit();
                } else {
                    $_SESSION['error'] = "Erreur lors de la suppression des étudiants.";
                }
            } else {
                $_SESSION['error'] = "Aucun étudiant sélectionné.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur : " . $e->getMessage();
        }
    }

    // Méthode pour exporter les étudiants (CSV)
    public function exporterEtudiants()
    {
        try {
            $etudiants = $this->etudiant->getAllEtudiant();

            // Définir les en-têtes pour le téléchargement CSV
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="etudiants_' . date('Y-m-d') . '.csv"');

            // Créer le fichier CSV
            $output = fopen('php://output', 'w');

            // Ajouter l'en-tête du CSV
            fputcsv($output, ['Numéro Étudiant', 'Nom', 'Prénom', 'Date de Naissance', 'Genre', 'Login']);

            // Ajouter les données
            foreach ($etudiants as $etudiant) {
                fputcsv($output, [
                    $etudiant->num_etu,
                    $etudiant->nom_etu,
                    $etudiant->prenom_etu,
                    $etudiant->date_naiss_etu,
                    $etudiant->genre_etu,
                    $etudiant->login_etu
                ]);
            }

            fclose($output);
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de l'exportation : " . $e->getMessage();
            header("Location: ?page=gestion_etudiants");
            exit();
        }
    }

    // Méthode pour rechercher des étudiants
    public function rechercherEtudiants($terme)
    {
        try {
            // Votre modèle n'a pas de méthode de recherche, donc on récupère tous les étudiants et on filtre
            $tousLesEtudiants = $this->etudiant->getAllEtudiant();
            $resultat = [];

            foreach ($tousLesEtudiants as $etudiant) {
                if (stripos($etudiant->num_etu, $terme) !== false ||
                    stripos($etudiant->nom_etu, $terme) !== false ||
                    stripos($etudiant->prenom_etu, $terme) !== false ||
                    stripos($etudiant->login_etu, $terme) !== false) {
                    $resultat[] = $etudiant;
                }
            }

            return $resultat;
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la recherche : " . $e->getMessage();
            return [];
        }
    }
}