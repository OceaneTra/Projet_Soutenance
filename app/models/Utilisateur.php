<?php

 class Utilisateur {
    private $id_utilisateur;
    private $login_utilisateur;
    private $password_hash;
    private $nom_utilisateur;
    private $prenom;
    private $id_groupe;

private $db;
    
public function __construct($db) {
    $this->db = $db;
}

public function verifierConnexion($login, $password) {
    $query = "SELECT id, password_hash, nom, prenom FROM utilisateurs WHERE login = :login";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password_hash'])) {
        return $user;
    }
    
    return false;
}

public function getGroupeUtilisateur($idUtilisateur) {
    $query = "SELECT id_groupe FROM utilisateurs WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $idUtilisateur);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id_groupe'] : null;
}
}