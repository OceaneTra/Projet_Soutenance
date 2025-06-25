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

        if ($user && password_verify(  $password,$user['mdp_utilisateur'] ) && $user['statut_utilisateur'] == 'Actif') {
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
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niv_acces_donnees
              WHERE u.id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $idUtilisateur);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUtilisateurs()
    {
        $sql = "SELECT u.*, tu.lib_type_utilisateur as role_utilisateur, 
                       gu.lib_GU, nad.lib_niveau_acces_donnees as niveau_acces
                FROM utilisateur u
                LEFT JOIN type_utilisateur tu ON u.id_type_utilisateur = tu.id_type_utilisateur
                LEFT JOIN groupe_utilisateur gu ON u.id_GU = gu.id_GU
                LEFT JOIN niveau_acces_donnees nad ON u.id_niv_acces_donnee = nad.id_niveau_acces_donnees
                ORDER BY u.nom_utilisateur";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUtilisateurById($id)
    {
        $sql = "SELECT u.*, nad.id_niveau_acces_donnees as id_niv_acces_donnee 
                FROM utilisateur u
                LEFT JOIN niveau_acces_donnees nad ON u.id_niv_acces_donnee = nad.id_niveau_acces_donnees
                WHERE u.id_utilisateur = :id";
        $stmt = $this->db->prepare($sql);
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

    public function updateUtilisateur($nom, $id_type_utilisateur, $id_GU, $id_niv_acces_donnees, $statut_utilisateur, $login,  $id)
    {
        $query = "UPDATE utilisateur SET nom_utilisateur = :nom, login_utilisateur = :login, id_GU = :id_GU, id_type_utilisateur = :id_type_utilisateur, id_niv_acces_donnee = :id_niv_acces_donnees,statut_utilisateur = :statut  WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':id_GU', $id_GU);
        $stmt->bindParam(':statut', $statut_utilisateur);
        $stmt->bindParam(':id_type_utilisateur', $id_type_utilisateur);
        $stmt->bindParam(':id_niv_acces_donnees', $id_niv_acces_donnees);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Désactive un utilisateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool True si la désactivation a réussi
     */
    public function desactiverUtilisateur($id)
    {
        $sql = "UPDATE utilisateur SET statut_utilisateur = 'Inactif' WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Réactive un utilisateur
     * 
     * @param int $id ID de l'utilisateur
     * @return bool True si la réactivation a réussi
     */
    public function reactiverUtilisateur($id)
    {
        $sql = "UPDATE utilisateur SET statut_utilisateur = 'Actif' WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updatePassword($id, $newPassword)
    {
        $query = "UPDATE utilisateur SET mdp_utilisateur = :mdp WHERE id_utilisateur = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':mdp', $newPassword);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAllUtilisateursActifs()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE u.statut_utilisateur = 'Actif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getAllUtilisateursInactifs()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE u.statut_utilisateur = 'Inactif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getAllUtilisateursByType($type)
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE t.lib_type_utilisateur = :type
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllUtilisateursByGroupe($groupe)
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE g.lib_GU = :groupe
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':groupe', $groupe);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEnseignantActif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE (t.lib_type_utilisateur = 'Enseignant Simple' OR t.lib_type_utilisateur='Enseignant Administratif' ) AND u.statut_utilisateur = 'Actif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEnseignantInactif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE (t.lib_type_utilisateur = 'Enseignant Simple' OR t.lib_type_utilisateur='Enseignant Administratif' ) AND u.statut_utilisateur = 'Inactif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
   public function getEtudiantActif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE t.lib_type_utilisateur = 'Etudiant' AND u.statut_utilisateur = 'Actif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEtudiantInactif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE t.lib_type_utilisateur = 'Etudiant' AND u.statut_utilisateur = 'Inactif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getPersAdminActif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE t.lib_type_utilisateur = 'Personnel Administratif' AND u.statut_utilisateur = 'Actif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getPersAdminInactif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE t.lib_type_utilisateur = 'Personnel Administratif' AND u.statut_utilisateur = 'Inactif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getAllUtilisateursByStatut($statut)
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE u.statut_utilisateur = :statut
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':statut', $statut);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUtilisateurActif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE u.statut_utilisateur = 'Actif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getUtilisateurInactif()
    {
        $query = "SELECT u.id_utilisateur, u.nom_utilisateur, u.login_utilisateur, 
                    u.statut_utilisateur,
                    t.lib_type_utilisateur as role_utilisateur,
                    g.lib_GU as gu,
                    n.lib_niveau_acces_donnees as niveau_acces
              FROM utilisateur u
              LEFT JOIN type_utilisateur t ON u.id_type_utilisateur = t.id_type_utilisateur
              LEFT JOIN groupe_utilisateur g ON u.id_GU = g.id_GU
              LEFT JOIN niveau_acces_donnees n ON u.id_niv_acces_donnee = n.id_niveau_acces_donnees
              WHERE u.statut_utilisateur = 'Inactif'
              ORDER BY u.nom_utilisateur";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Récupérer les enseignants non enregistrés comme utilisateurs
    public function getEnseignantsNonUtilisateurs() {
        $query = "SELECT e.id_enseignant, e.nom_enseignant, e.prenom_enseignant, e.mail_enseignant 
                 FROM enseignants e 
                 LEFT JOIN utilisateur u ON e.mail_enseignant = u.login_utilisateur 
                 WHERE u.id_utilisateur IS NULL 
                 ORDER BY e.nom_enseignant, e.prenom_enseignant";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Récupérer le personnel administratif non enregistré comme utilisateur
    public function getPersonnelNonUtilisateurs() {
        $query = "SELECT pa.id_pers_admin, pa.nom_pers_admin, pa.prenom_pers_admin, pa.email_pers_admin 
                 FROM personnel_admin pa 
                 LEFT JOIN utilisateur u ON pa.email_pers_admin = u.login_utilisateur 
                 WHERE u.id_utilisateur IS NULL 
                 ORDER BY pa.nom_pers_admin, pa.prenom_pers_admin";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Récupérer les étudiants non enregistrés comme utilisateurs
    public function getEtudiantsNonUtilisateurs() {
        $query = "SELECT e.num_etu, e.nom_etu, e.prenom_etu,e.email_etu
                 FROM etudiants e 
                 LEFT JOIN utilisateur u ON e.email_etu = u.login_utilisateur 
                 WHERE u.id_utilisateur IS NULL 
                 ORDER BY e.nom_etu, e.prenom_etu";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Récupérer les étudiants en Master 2 non enregistrés comme utilisateurs
    public function getEtudiantsMaster2NonUtilisateurs() {
        $query = "SELECT e.num_etu, e.nom_etu, e.prenom_etu, e.email_etu, n.lib_niv_etude
                 FROM etudiants e 
                 INNER JOIN inscriptions i ON e.num_etu = i.id_etudiant
                 INNER JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude
                 LEFT JOIN utilisateur u ON e.email_etu = u.login_utilisateur 
                 WHERE u.id_utilisateur IS NULL 
                 AND n.id_niv_etude = 9
                 AND i.id_inscription = (
                     SELECT i2.id_inscription FROM inscriptions i2
                     WHERE i2.id_etudiant = e.num_etu
                     ORDER BY i2.date_inscription DESC LIMIT 1
                 )
                 ORDER BY e.nom_etu, e.prenom_etu";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Vérifier si un login (email) est déjà utilisé
    public function isLoginUsed($login) {
        $query = "SELECT COUNT(*) as count FROM utilisateur WHERE login_utilisateur = :login";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
 // Fonction pour générer un mot de passe aléatoire
    function generateRandomPassword($length = 12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $password;
    }
    // Ajouter plusieurs utilisateurs en masse
    public function ajouterUtilisateursEnMasse($utilisateurs) {
        $this->db->beginTransaction();
        try {
            $utilisateursAjoutes = [];
            foreach ($utilisateurs as $utilisateur) {
                $mdp = $this->generateRandomPassword();
                $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
                
                if ($this->ajouterUtilisateur(
                    $utilisateur['nom'],
                    $utilisateur['id_type'],
                    $utilisateur['id_groupe'],
                    $utilisateur['id_niveau'],
                    $utilisateur['statut'],
                    $utilisateur['login'],
                    $mdp_hash
                )) {
                    $utilisateursAjoutes[] = [
                        'nom' => $utilisateur['nom'],
                        'login' => $utilisateur['login'],
                        'mdp' => $mdp
                    ];
                } else {
                    throw new Exception("Erreur lors de l'ajout de l'utilisateur " . $utilisateur['nom']);
                }
            }
            $this->db->commit();
            return $utilisateursAjoutes;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Récupérer un enseignant par son ID
    public function getEnseignantById($id) {
        $sql = "SELECT * FROM enseignants WHERE id_enseignant = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Récupérer un membre du personnel par son ID
    public function getPersonnelById($id) {
        $sql = "SELECT * FROM personnel_admin WHERE id_pers_admin = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Récupérer un étudiant par son ID
    public function getEtudiantById($id) {
        $sql = "SELECT * FROM etudiants WHERE num_etu = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    
    
    
}