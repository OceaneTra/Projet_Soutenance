<?php

 class Utilisateur {
   
private $db;
    
public function __construct($db) {
    $this->db = $db;
}

public function verifierConnexion($login, $password) {
    
    $query = "SELECT id_utilisateur,id_GU,nom_utilisateur,statut_utilisateur,login_utilisateur,mdp_utilisateur FROM utilisateur WHERE login_utilisateur = :login";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $user['mdp_utilisateur']== $password) {
        // Vérification du mot de passe
        return $user;
    }
    
    return false;
}



/**
 * Récupère le libellé du type d'utilisateur à partir de l'ID utilisateur
 * @param int $idUtilisateur ID de l'utilisateur
 * @return string|null Le libellé du type d'utilisateur ou null si non trouvé
*/
public function getLibelleTypeUtilisateur($idUtilisateur) {
    $query = "SELECT t.lib_type_utilisateur 
              FROM utilisateur u
              JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              WHERE u.id_utilisateur = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $idUtilisateur);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['lib_type_utilisateur'] : null;
}
 

 
/**
 * Récupère le libellé du niveau d'accès à partir de l'ID utilisateur
 * @param int $idUtilisateur ID de l'utilisateur
 * @return string|null Le libellé du niveau d'accès ou null si non trouvé
 */
public function getLibelleNivAcces($idUtilisateur) {
    $query = "SELECT n.lib_niveau_acces_donnees
              FROM utilisateur u
              JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE u.id_utilisateur = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $idUtilisateur);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['lib_niveau_acces_donnees'] : null;
}

/**
 * Récupère tous les libellés liés à un utilisateur en une seule méthode
 * @param int $idUtilisateur ID de l'utilisateur
 * @return array Tableau contenant tous les libellés ou null si non trouvé
 */
public function getAllUserLabels($idUtilisateur) {
    $query = "SELECT 
                g.lib_groupe,
                f.lib_fonction,
                t.lib_type_utilisateur,
                n.lib_niveau_acces_donnees
              FROM utilisateur u
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN fonction f ON u.id_fonction = f.id_fonction
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnees = n.id_niv_acces_donnees
              WHERE u.id_utilisateur = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $idUtilisateur);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}