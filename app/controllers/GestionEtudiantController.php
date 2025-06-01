<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Etudiant.php";

class GestionEtudiantController
{
    private $etudiant;
    private $baseViewPath;
    private $db;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->baseViewPath = __DIR__ . '/../../ressources/views/';
        $this->db = Database::getConnection();
        $this->etudiant = new Etudiant($this->db);
    }

    private function genererNumeroEtudiant($promotion_etu) {
        // Extraire l'année de début de la promotion (ex: "2023-2024" -> "2023")
        $annee = explode('-', $promotion_etu)[0];
        
        // Rechercher le dernier numéro pour cette promotion
        $query = "SELECT MAX(CAST(SUBSTRING(num_etu, 5) AS UNSIGNED)) as max_num FROM etudiants WHERE num_etu LIKE :prefix";
        $stmt = $this->db->prepare($query);
        $prefix = $annee . '%';
        $stmt->bindParam(':prefix', $prefix);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        
        $next_num = ($result->max_num ?? 0) + 1;
        return $annee . str_pad($next_num, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        try {
            $currentPage = isset($_GET['p']) ? (int)$_GET['p'] : 1;
            $itemsPerPage = 10;
            $etudiant_a_modifier = null;
            $modalAction = '';
            $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

            // Gestion des actions GET pour les modales
            if (isset($_GET['modalAction']) && $_GET['modalAction'] === 'edit' && isset($_GET['num_etu'])) {
                $etudiant_a_modifier = $this->etudiant->getEtudiantById($_GET['num_etu']);
                if (!$etudiant_a_modifier) {
                    $GLOBALS['messageErreur'] = "Étudiant non trouvé.";
                } else {
                    $modalAction = 'edit';
                    // Si c'est une requête AJAX, renvoyer les données en JSON
                    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'num_etu' => $etudiant_a_modifier->num_etu,
                            'nom_etu' => $etudiant_a_modifier->nom_etu,
                            'prenom_etu' => $etudiant_a_modifier->prenom_etu,
                            'date_naiss_etu' => $etudiant_a_modifier->date_naiss_etu,
                            'genre_etu' => $etudiant_a_modifier->genre_etu,
                            'email_etu' => $etudiant_a_modifier->email_etu,
                            'promotion_etu' => $etudiant_a_modifier->promotion_etu
                        ]);
                        exit;
                    }
                }
            }

            // Gestion des actions POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Ajout d'un nouvel étudiant
                if (isset($_POST['submit_add_etudiant'])) {
                    // Validation des champs
                    if (empty($_POST['nom_etu']) || empty($_POST['prenom_etu']) || 
                        empty($_POST['date_naiss_etu']) || empty($_POST['genre_etu']) || 
                        empty($_POST['email_etu']) || empty($_POST['promotion_etu'])) {
                        $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
                        return;
                    }

                    $num_etu = $this->genererNumeroEtudiant($_POST['promotion_etu']);
                    $nom_etu = trim($_POST['nom_etu']);
                    $prenom_etu = trim($_POST['prenom_etu']);
                    $date_naiss_etu = $_POST['date_naiss_etu'];
                    $genre_etu = $_POST['genre_etu'];
                    $email_etu = trim($_POST['email_etu']);
                    $promotion_etu = $_POST['promotion_etu'];

                    // Validation de l'email
                    if (!filter_var($email_etu, FILTER_VALIDATE_EMAIL)) {
                        $GLOBALS['messageErreur'] = "L'adresse email n'est pas valide.";
                        return;
                    }

                    if ($this->etudiant->ajouterEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $email_etu, $promotion_etu)) {
                        $GLOBALS['messageSuccess'] = "Étudiant ajouté avec succès. Numéro étudiant : " . $num_etu;
                    } else {
                        $GLOBALS['messageErreur'] = "Erreur lors de l'ajout de l'étudiant.";
                    }
                }

                // Modification d'un étudiant
                if (isset($_POST['submit_modifier_etudiant'])) {
                    if (empty($_POST['num_etu']) || empty($_POST['nom_etu']) || 
                        empty($_POST['prenom_etu']) || empty($_POST['date_naiss_etu']) || 
                        empty($_POST['genre_etu']) || empty($_POST['email_etu']) || 
                        empty($_POST['promotion_etu'])) {
                        $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
                        return;
                    }

                    $num_etu = $_POST['num_etu'];
                    $nom_etu = trim($_POST['nom_etu']);
                    $prenom_etu = trim($_POST['prenom_etu']);
                    $date_naiss_etu = $_POST['date_naiss_etu'];
                    $genre_etu = $_POST['genre_etu'];
                    $email_etu = trim($_POST['email_etu']);
                    $promotion_etu = $_POST['promotion_etu'];

                    // Validation de l'email
                    if (!filter_var($email_etu, FILTER_VALIDATE_EMAIL)) {
                        $GLOBALS['messageErreur'] = "L'adresse email n'est pas valide.";
                        return;
                    }

                    if ($this->etudiant->modifierEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $email_etu, $promotion_etu)) {
                        $GLOBALS['messageSuccess'] = "Étudiant modifié avec succès.";
                    } else {
                        $GLOBALS['messageErreur'] = "Erreur lors de la modification de l'étudiant.";
                    }
                }

                // Suppression d'étudiants
                if (isset($_POST['selected_ids']) && !empty($_POST['selected_ids'])) {
                    $success = true;
                    foreach ($_POST['selected_ids'] as $num_etu) {
                        if (!$this->etudiant->supprimerEtudiant($num_etu)) {
                            $success = false;
                            break;
                        }
                    }
                    if ($success) {
                        $GLOBALS['messageSuccess'] = "Étudiants supprimés avec succès.";
                    } else {
                        $GLOBALS['messageErreur'] = "Erreur lors de la suppression des étudiants.";
                    }
                }
            }

            // Récupération des données pour l'affichage
            $listeEtudiants = $this->etudiant->getAllEtudiants();
            
            // Filtrer les étudiants si un terme de recherche est présent
            if (!empty($searchTerm)) {
                $listeEtudiants = array_filter($listeEtudiants, function($etudiant) use ($searchTerm) {
                    $searchTerm = strtolower($searchTerm);
                    return strpos(strtolower($etudiant->nom_etu), $searchTerm) !== false ||
                           strpos(strtolower($etudiant->prenom_etu), $searchTerm) !== false;
                });
            }

            // Convertir le résultat en tableau indexé
            $listeEtudiants = array_values($listeEtudiants);

            $totalItems = count($listeEtudiants);
            $totalPages = ceil($totalItems / $itemsPerPage);
            
            // Validation de la page courante
            if ($currentPage < 1) {
                $currentPage = 1;
            } elseif ($currentPage > $totalPages && $totalPages > 0) {
                $currentPage = $totalPages;
            }
            
            $startIndex = ($currentPage - 1) * $itemsPerPage;
            $endIndex = min($startIndex + $itemsPerPage, $totalItems);
            
            // Récupérer les étudiants pour la page courante
            $currentPageItems = array_slice($listeEtudiants, $startIndex, $itemsPerPage);

            // Debug pour vérifier les valeurs
            error_log("Current Page: " . $currentPage);
            error_log("Total Pages: " . $totalPages);
            error_log("Total Items: " . $totalItems);
            error_log("Start Index: " . $startIndex);
            error_log("End Index: " . $endIndex);
            error_log("Items Per Page: " . $itemsPerPage);
            error_log("Current Page Items Count: " . count($currentPageItems));
            error_log("Liste Etudiants Count: " . count($listeEtudiants));

            // Préparation des données pour la vue
            $GLOBALS['listeEtudiants'] = $currentPageItems;
            $GLOBALS['allEtudiants'] = $listeEtudiants;
            $GLOBALS['etudiant_a_modifier'] = $etudiant_a_modifier;
            $GLOBALS['modalAction'] = $modalAction;
            $GLOBALS['currentPage'] = $currentPage;
            $GLOBALS['totalPages'] = $totalPages;
            $GLOBALS['totalItems'] = $totalItems;
            $GLOBALS['startIndex'] = $startIndex;
            $GLOBALS['endIndex'] = $endIndex;
            $GLOBALS['itemsPerPage'] = $itemsPerPage;
            $GLOBALS['searchTerm'] = $searchTerm;

        } catch (Exception $e) {
            error_log("Erreur dans GestionEtudiantController::index : " . $e->getMessage());
            $GLOBALS['messageErreur'] = "Une erreur est survenue. Veuillez réessayer.";
        }
    }

}