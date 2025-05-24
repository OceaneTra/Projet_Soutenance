<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Traitement.php';
require_once __DIR__ . '/../models/Enseignant.php';
require_once __DIR__ . '/../models/PersAdmin.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Fonction.php';
require_once __DIR__ . '/../models/Specialite.php';
 // Si nécessaire pour d'autres opérations





class AuthController {
    private $db;
    private $enseignantModel;
    private $persAdminModel;
    private $gradeModel;
    private $fonctionModel;
    private $specialiteModel;
  
    
    public function __construct($db) {
        $this->db = $db;
        $this->enseignantModel = new Enseignant($db);
        $this->persAdminModel = new PersAdmin($db);
        $this->gradeModel = new Grade($db);
        $this->fonctionModel = new Fonction($db);
        $this->specialiteModel = new Specialite($db);
    }
    

    public function login($login, $password) {
        $utilisateur = new Utilisateur($this->db);
        $infoUtilisateur = $utilisateur->verifierConnexion($login, $password);
        
        if ($infoUtilisateur) {
            // Démarrer la session si pas déjà fait
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            // Stocker les infos de session
            $_SESSION['id_utilisateur'] = $infoUtilisateur['id_utilisateur'];
            $_SESSION['nom_utilisateur'] = $infoUtilisateur['nom_utilisateur'];
            $_SESSION['statut_utilisateur'] = $infoUtilisateur['statut_utilisateur'];
            $_SESSION['login_utilisateur'] = $infoUtilisateur['login_utilisateur'];
            // Récupérer les autres infos via le modèle
            $_SESSION['type_utilisateur'] = $utilisateur->getLibelleTypeUtilisateur($infoUtilisateur['id_utilisateur']);
            $_SESSION['id_GU'] = $infoUtilisateur['id_GU'];
            $_SESSION['lib_GU'] = $utilisateur->getLibelleGroupeUtilisateur($infoUtilisateur['id_utilisateur']);
            $_SESSION['niveau_acces'] = $utilisateur->getLibelleNivAcces($infoUtilisateur['id_utilisateur']);

            $type_utilisateur = $utilisateur->getLibelleTypeUtilisateur($infoUtilisateur['id_utilisateur']);

            if($type_utilisateur !== 'Etudiant'){
                if($type_utilisateur === 'Enseignant simple' || $type_utilisateur === 'Enseignant administratif'){
                    // Récupérer les informations de l'enseignant
                    $enseignant = $this->enseignantModel->getEnseignantById($infoUtilisateur['id_utilisateur']);
                    if($enseignant) {
                        $_SESSION['specialite'] = $enseignant->lib_specialite;
                        $_SESSION['grade'] = $enseignant->lib_grade;
                        $_SESSION['fonction'] = $enseignant->lib_fonction;
                        $_SESSION['date_grade'] = $enseignant->date_grade;
                        $_SESSION['date_fonction'] = $enseignant->date_occupation;
                    }
                }
                else if($type_utilisateur === 'Personnel administratif'){
                    // Récupérer les informations du personnel administratif
                    $persAdmin = $this->persAdminModel->getPersAdminById($infoUtilisateur['id_utilisateur']);
                    if($persAdmin) {
                        $_SESSION['telephone'] = $persAdmin->tel_pers_admin;
                        $_SESSION['poste'] = $persAdmin->poste;
                        $_SESSION['date_embauche'] = $persAdmin->date_embauche;
                    }
                }
            }
            
            // NE PAS stocker le mot de passe en session
            // $_SESSION['mdp_utilisateur'] = $infoUtilisateur['mdp_utilisateur'];
            
            return true;
        }
        return false;
    }
    public function logout()
    {
        // Détruire toutes les données de session
        $_SESSION = array();
    
        // Si vous voulez détruire complètement la session, effacez aussi le cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    
        // Finalement, détruire la session
        return session_destroy();
    }
}