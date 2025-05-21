<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";

class GestionUtilisateurController
{
    private $utilisateur;
    private $baseViewPath;

    public function __construct()
    {

        $this->baseViewPath = __DIR__ . '/../../ressources/views/admin/';
        $this->utilisateur = new Utilisateur(Database::getConnection());

    }

    // Afficher la liste des étudiants
    public function index()
    {

        $utilisateur_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';
        try {
            // Vérifier si une action a été demandée
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if (isset($_POST['ajouter'])) {
                  
                $nom_utilisateur = $_POST['nom_utilisateur'];
                $id_type_utilisateur = $_POST['id_type_utilisateur'] ;
                $id_GU = $_POST['id_GU'] ?? ''; 
                $login_utilisateur = $_POST['login_utilisateur'] ;
                $mdp_utilisateur = $_POST['mdp_utilisateur'] ;
                $statut_utilisateur = $_POST['statut_utilisateur'] ;
                $id_utilisateur = $_POST['id_utilisateur'] ;
                $id_niveau_acces= $_POST['id_niveau_acces'] ;


                
                    $this->utilisateur->ajouterUtilisateur( 
                        $nom_utilisateur,
                        $id_type_utilisateur,
                        $id_GU,
                        $login_utilisateur,
                        $mdp_utilisateur,
                        $statut_utilisateur,
                        $id_utilisateur,
                        $id_niveau_acces
                    );
                } elseif (isset($_POST['modifier'])) {
                    $this->utilisateur->updateUtilisateur(
                        $_POST['id_utilisateur'],
                        $_POST['nom_utilisateur'],
                        $_POST['id_type_utilisateur'],
                        $_POST['id_GU'],
                        $_POST['login_utilisateur'],
                        $_POST['mdp_utilisateur'],
                        $_POST['statut_utilisateur'],
                        $_POST['id_niveau_acces']
                    );
                } elseif (isset($_POST['supprimer'])) {
                    $this->utilisateur->desactiverUtilisateur(
                        $_POST['id_utilisateur']
                    );
                }
            }

            // Récupérer la liste des utilisateurs
            $utilisateurs = $this->utilisateur->getAllUtilisateurs();

            // Vérifier si un utilisateur doit être modifié
            if (isset($_GET['id'])) {
                $utilisateur_a_modifier = $this->utilisateur->getUtilisateurById($_GET['id']);
            }   

        } catch (Exception $e) {
            $messageErreur = "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
        }   

    }

  
}