<?php

class Utilisateur
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function verifierConnexion($login, $password)
    {

        $query = "SELECT id_utilisateur,id_GU,nom_utilisateur,statut_utilisateur,login_utilisateur,mdp_utilisateur FROM utilisateur WHERE login_utilisateur = :login";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['mdp_utilisateur'] == $password && $user['statut_utilisateur'] == 'Actif') {
            // Vérification du mot de passe
            return $user;
        }

        return false;
    }

    /**
     * Récupère le libellé du groupe utilisateur à partir de l'ID utilisateur
     * @param int $idUtilisateur ID de l'utilisateur
     * @return string|null Le libellé du groupe ou null si non trouvé
     */
    public function getLibelleGroupeUtilisateur($idUtilisateur)
    {
        $query = "SELECT g.lib_GU 
              FROM utilisateur u
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              WHERE u.id_utilisateur = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $idUtilisateur, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['lib_GU'] ?? 'Aucun groupe'; // Valeur par défaut
        }

        return null;
    }


    /**
     * Récupère le libellé du type d'utilisateur à partir de l'ID utilisateur
     * @param int $idUtilisateur ID de l'utilisateur
     * @return string|null Le libellé du type d'utilisateur ou null si non trouvé
     */
    public function getLibelleTypeUtilisateur($idUtilisateur)
    {
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
    public function getLibelleNivAcces($idUtilisateur)
    {
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
    public function getAllUserLabels($idUtilisateur)
    {
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

    public function getAllUtilisateurs()
    {
        $query = "SELECT u.*, 
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUtilisateurById($id)
    {
        $query = "SELECT u.*, t.lib_type_utilisateur, g.lib_GU, n.lib_niveau_acces_donnees
                 FROM utilisateur u 
                 JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
                 JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
                 JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
                 WHERE u.id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getUtilisateurByLogin($login)
    {
        $query = "SELECT u.*, t.lib_type_utilisateur, g.lib_GU, n.lib_niveau_acces_donnees
                 FROM utilisateur u 
                 JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
                 JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
                 JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
                 WHERE u.login_utilisateur = :login";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function ajouterUtilisateur($nom, $id_type_utilisateur, $id_GU, $id_niv_acces_donnees, $statut_utilisateur, $login, $mdp)
    {

        $query = "INSERT INTO utilisateur (nom_utilisateur,id_type_utilisateur,id_GU,id_niv_acces_donnee,statut_utilisateur, login_utilisateur, mdp_utilisateur ) 
                  VALUES (:nom,:id_type_utilisateur ,:id_GU,:id_niv_acces_donnees, :statut_utilisateur,:login, :mdp )";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':id_type_utilisateur', $id_type_utilisateur);
        $stmt->bindParam(':id_GU', $id_GU);
        $stmt->bindParam(':id_niv_acces_donnees', $id_niv_acces_donnees);
        $stmt->bindParam(':statut_utilisateur', $statut_utilisateur);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':mdp', $mdp);
        return $stmt->execute();
    }

    public function updateUtilisateur($nom, $id_type_utilisateur, $id_GU, $id_niv_acces_donnees, $statut_utilisateur, $login, $mdp, $id)
    {
        $query = "UPDATE utilisateur SET nom_utilisateur = :nom, login_utilisateur = :login, mdp_utilisateur = :mdp, id_GU = :id_GU, id_type_utilisateur = :id_type_utilisateur, id_niv_acces_donnees = :id_niv_acces_donnees,statut_utilisateur = :statut  WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':mdp', $mdp);
        $stmt->bindParam(':id_GU', $id_GU);
        $stmt->bindParam(':statut', $statut_utilisateur);
        $stmt->bindParam(':id_type_utilisateur', $id_type_utilisateur);
        $stmt->bindParam(':id_niv_acces_donnees', $id_niv_acces_donnees);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function desactiverUtilisateur($id)
    {
        $query = "UPDATE utilisateur SET statut_utilisateur = :statut  WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $statut = 'Inactif';
        $stmt->bindParam(':statut', $statut);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updatePassword($newPassword, $id)
    {
        $query = "UPDATE utilisateur SET mdp_utilisateur = :mdp  WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mdp', $newPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
