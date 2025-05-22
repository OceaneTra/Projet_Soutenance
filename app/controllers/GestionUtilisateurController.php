<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/TypeUtilisateur.php";
require_once __DIR__ . "/../models/GroupeUtilisateur.php";
require_once __DIR__ . "/../models/NiveauAccesDonnees.php";

class GestionUtilisateurController
{
    private $utilisateur;
    private $baseViewPath;

    private $typeUtilisateur;

    private $groupeUtilisateur;

    private $niveauAcces;



    public function __construct()
    {

        $this->baseViewPath = __DIR__ . '/../../ressources/views/';
        $this->utilisateur = new Utilisateur(Database::getConnection());
        $this->groupeUtilisateur = new GroupeUtilisateur(Database::getConnection());
        $this->typeUtilisateur = new TypeUtilisateur(Database::getConnection());
        $this->niveauAcces = new NiveauAccesDonnees(Database::getConnection());

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

            if (isset($_POST['btn_add_utilisateur']) || isset($_POST['btn_modifier_utilisateur']) ) {
                  
                $nom_utilisateur = $_POST['nom_utilisateur'];
                $id_type_utilisateur = $_POST['id_type_utilisateur'] ;
                $id_GU = $_POST['id_GU']; 
                $login_utilisateur = $_POST['login_utilisateur'] ;
                $mdp_utilisateur = $_POST['mdp_utilisateur'] ;
                $statut_utilisateur = $_POST['statut_utilisateur'] ;
                $id_utilisateur = $_POST['id_utilisateur'] ;
                $id_niveau_acces= $_POST['id_niveau_acces'] ;

                if($this->utilisateur->ajouterUtilisateur( $nom_utilisateur,$id_type_utilisateur,$id_GU,$id_niveau_acces, $statut_utilisateur,$login_utilisateur)){
                    $messageSuccess = "Utilisateur ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'utilisateur.";
                }

                if($_POST['id_utilisateur']){
                    $this->utilisateur->updateUtilisateur($nom_utilisateur,$id_type_utilisateur,$id_GU,$id_niveau_acces,$statut_utilisateur,$login_utilisateur,$mdp_utilisateur,$id_utilisateur);
                    $messageSuccess = "Utilisateur modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'utilisateur.";
                }

                if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
                    $success = true;
                    foreach ($_POST['selected_ids'] as $id) {
                        if (!$this->utilisateur->desactiverUtilisateur($id)) {
                            $success = false;
                            break;
                        }
                    }
        
                    if ($success) {
                        $messageSuccess = "Utilisateurs désactiver avec succès.";
                    } else {
                        $messageErreur = "Erreur lors de la désactivation des utilisateurs.";
                    }
                }
        
                if (isset($_GET['id_utilisateur'])) {
                    $utilisateur_a_modifier = $this->utilisateur->getUtilisateurById($_GET['id_utilisateur']);
                }
                
                 
            }
            }
    
         

        } catch (Exception $e) {
            $messageErreur = "Erreur lors de la récupération des utilisateurs : " . $e->getMessage();
        }   


        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
        $GLOBALS['utilisateurs'] = $this->utilisateur->getAllUtilisateurs();
        $GLOBALS['types_utilisateur'] = $this->typeUtilisateur->getAllTypeUtilisateur();
        $GLOBALS['groupes_utilisateur'] = $this->groupeUtilisateur->getAllGroupeUtilisateur();
        $GLOBALS['niveau_acces'] = $this->niveauAcces->getAllNiveauxAccesDonnees();
        $GLOBALS['utilisateur_a_modifier'] = $utilisateur_a_modifier;


    }

  
}