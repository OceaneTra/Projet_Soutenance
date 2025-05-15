<?php
include_once '../models/Utilisateur.php';


class AuthController {
    public function login($login, $password) {
        $utilisateur = new Utilisateur();
        $infoUtilisateur = $utilisateur->verifierConnexion($login, $password);
        
        if ($infoUtilisateur) {
            // Démarrage session et stockage des infos
            session_start();
            $_SESSION['user_id'] = $infoUtilisateur['id'];
            $_SESSION['groupe_id'] = $utilisateur->getGroupeUtilisateur($infoUtilisateur['id']);
            return true;
        }
        return false;
    }
}