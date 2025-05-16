<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Utilisateur.php';
require_once __DIR__ . '/../models/Traitement.php'; // Si nécessaire pour d'autres opérations





class AuthController {
    private $db;
  
    
    public function __construct($db) {
        $this->db = $db;

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
            $_SESSION['niveau_acces'] = $utilisateur->getLibelleNivAcces($infoUtilisateur['id_utilisateur']);
            
            // NE PAS stocker le mot de passe en session
            // $_SESSION['mdp_utilisateur'] = $infoUtilisateur['mdp_utilisateur'];
            
            return true;
        }
        return false;
    }
    public function logout()
    {

        // Détruire la session
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: ../public/page_connexion.php");
        exit();
    }
}