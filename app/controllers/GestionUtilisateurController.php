<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/TypeUtilisateur.php";
require_once __DIR__ . "/../models/GroupeUtilisateur.php";
require_once __DIR__ . "/../models/NiveauAccesDonnees.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

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
        $action = $_GET['action'] ?? '';

        try {
            // Gestion des actions GET pour les modales
            if ($action === 'edit' && isset($_GET['id_utilisateur'])) {
                $utilisateur_a_modifier = $this->utilisateur->getUtilisateurById($_GET['id_utilisateur']);
                if (!$utilisateur_a_modifier) {
                    $messageErreur = "Utilisateur non trouvé.";
                }
            }
            // Gestion de la requête AJAX pour obtenir la liste des utilisateurs
            else if ($action === 'get_users' && isset($_GET['type'])) {
                $type = $_GET['type'];
                $users = [];
                
                switch ($type) {
                    case 'etudiant':
                        require_once __DIR__ . "/../models/Etudiants.php";
                        $etudiantModel = new Etudiants(Database::getConnection());
                        $etudiants = $etudiantModel->getAllEtudiant();
                        foreach ($etudiants as $etudiant) {
                            if (!$this->utilisateur->getUtilisateurByLogin($etudiant->login_etu)) {
                                $users[] = [
                                    'id' => $etudiant->num_etu,
                                    'nom' => $etudiant->nom_etu,
                                    'prenom' => $etudiant->prenom_etu,
                                    'email' => $etudiant->login_etu
                                ];
                            }
                        }
                        break;
                    case 'enseignant':
                        require_once __DIR__ . "/../models/Enseignant.php";
                        $enseignantModel = new Enseignant(Database::getConnection());
                        $enseignants = $enseignantModel->getAllEnseignants();
                        foreach ($enseignants as $enseignant) {
                            if (!$this->utilisateur->getUtilisateurByLogin($enseignant->email_enseignant)) {
                                $users[] = [
                                    'id' => $enseignant->id_enseignant,
                                    'nom' => $enseignant->nom_enseignant,
                                    'prenom' => $enseignant->prenom_enseignant,
                                    'email' => $enseignant->email_enseignant
                                ];
                            }
                        }
                        break;
                    case 'pers_admin':
                        require_once __DIR__ . "/../models/PersAdmin.php";
                        $persAdminModel = new PersAdmin(Database::getConnection());
                        $persAdmins = $persAdminModel->getAllPersAdmin();
                        foreach ($persAdmins as $persAdmin) {
                            if (!$this->utilisateur->getUtilisateurByLogin($persAdmin->email_pers_admin)) {
                                $users[] = [
                                    'id' => $persAdmin->id_pers_admin,
                                    'nom' => $persAdmin->nom_pers_admin,
                                    'prenom' => $persAdmin->prenom_pers_admin,
                                    'email' => $persAdmin->email_pers_admin
                                ];
                            }
                        }
                        break;
                }
                
                header('Content-Type: application/json');
                echo json_encode($users);
                exit;
            }
            // Gestion de l'ajout en masse des utilisateurs
            else if (isset($_POST['btn_add_bulk_users'])) {
                $selectedUsers = $_POST['selected_users'] ?? [];
                $id_GU = $_POST['id_GU'] ?? null;
                $userType = $_POST['userType'] ?? '';

                if (empty($selectedUsers) || !$id_GU || !$userType) {
                    $messageErreur = "Veuillez sélectionner au moins un utilisateur et un groupe utilisateur.";
                } else {
                    $success = true;
                    $addedUsers = [];

                    foreach ($selectedUsers as $userId) {
                        $userInfo = $this->getUserInfo($userType, $userId);
                        if ($userInfo) {
                            // Générer un mot de passe aléatoire
                            $password = $this->generateRandomPassword();
                            
                            // Déterminer le type d'utilisateur
                            $id_type_utilisateur = $this->getTypeUtilisateurId($userType);
                            
                            // Ajouter l'utilisateur
                            if ($this->utilisateur->ajouterUtilisateur(
                                $userInfo['nom'] . ' ' . $userInfo['prenom'],
                                $id_type_utilisateur,
                                $id_GU,
                                1, // Niveau d'accès par défaut
                                'Actif',
                                $userInfo['email'],
                                password_hash($password, PASSWORD_DEFAULT)
                            )) {
                                $addedUsers[] = [
                                    'email' => $userInfo['email'],
                                    'password' => $password
                                ];
                            } else {
                                $success = false;
                            }
                        }
                    }

                    if ($success) {
                        // Envoyer les emails
                        $this->sendWelcomeEmails($addedUsers);
                        $messageSuccess = count($addedUsers) . " utilisateurs ont été ajoutés avec succès.";
                    } else {
                        $messageErreur = "Une erreur est survenue lors de l'ajout des utilisateurs.";
                    }
                }
            }

            // Gestion des actions POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Ajout d'un nouvel utilisateur
                if (isset($_POST['btn_add_utilisateur'])) {
                    $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
                    $id_type_utilisateur = $_POST['id_type_utilisateur'] ?? '';
                    $id_GU = $_POST['id_GU'] ?? '';
                    $login_utilisateur = $_POST['login_utilisateur'] ?? '';
                    $statut_utilisateur = $_POST['statut_utilisateur'] ?? '';
                    $id_niveau_acces = $_POST['id_niveau_acces'] ?? '';
                    
                    if (empty($nom_utilisateur) || empty($id_type_utilisateur) || empty($id_GU) || 
                        empty($login_utilisateur) || empty($statut_utilisateur) || empty($id_niveau_acces)) {
                        $messageErreur = "Tous les champs sont obligatoires.";
                    } else {
                        $mdp = $this->generateRandomPassword();
                        if ($this->utilisateur->ajouterUtilisateur(
                            $nom_utilisateur,
                            $id_type_utilisateur,
                            $id_GU,
                            $id_niveau_acces,
                            $statut_utilisateur,
                            $login_utilisateur,
                            $mdp
                        )) {
                            $emailSent = $this->envoyerEmailInscriptionPHPMailer($login_utilisateur, $nom_utilisateur, $login_utilisateur, $mdp);
                            $messageSuccess = $emailSent ? 
                                "Utilisateur ajouté avec succès et email envoyé." : 
                                "Utilisateur ajouté avec succès mais l'envoi de l'email a échoué.";
                        } else {
                            $messageErreur = "Erreur lors de l'ajout de l'utilisateur.";
                        }
                    }
                }

                // Modification d'un utilisateur
                if (isset($_POST['btn_modifier_utilisateur'])) {
                    $id_utilisateur = $_POST['id_utilisateur'] ?? '';
                    $nom_utilisateur = $_POST['nom_utilisateur'] ?? '';
                    $id_type_utilisateur = $_POST['id_type_utilisateur'] ?? '';
                    $id_GU = $_POST['id_GU'] ?? '';
                    $login_utilisateur = $_POST['login_utilisateur'] ?? '';
                    $statut_utilisateur = $_POST['statut_utilisateur'] ?? '';
                    $id_niveau_acces = $_POST['id_niveau_acces'] ?? '';
                    $mdp_utilisateur = $_POST['mdp_utilisateur'] ?? '';

                    if (empty($id_utilisateur) || empty($nom_utilisateur) || empty($id_type_utilisateur) || 
                        empty($id_GU) || empty($login_utilisateur) || empty($statut_utilisateur) || 
                        empty($id_niveau_acces)) {
                        $messageErreur = "Tous les champs sont obligatoires.";
                    } else {
                        if ($this->utilisateur->updateUtilisateur(
                            $nom_utilisateur,
                            $id_type_utilisateur,
                            $id_GU,
                            $id_niveau_acces,
                            $statut_utilisateur,
                            $login_utilisateur,
                            $mdp_utilisateur,
                            $id_utilisateur
                        )) {
                            $messageSuccess = "Utilisateur modifié avec succès.";
                        } else {
                            $messageErreur = "Erreur lors de la modification de l'utilisateur.";
                        }
                    }
                }

                // Désactivation d'un utilisateur
                if (isset($_POST['btn_desactiver_utilisateur'])) {
                    $id_utilisateur = $_POST['id_utilisateur'] ?? '';
                    if (empty($id_utilisateur)) {
                        $messageErreur = "ID utilisateur manquant.";
                    } else {
                        if ($this->utilisateur->desactiverUtilisateur($id_utilisateur)) {
                            $messageSuccess = "Utilisateur désactivé avec succès.";
                        } else {
                            $messageErreur = "Erreur lors de la désactivation de l'utilisateur.";
                        }
                    }
                }

                // Désactivation multiple d'utilisateurs
                if (isset($_POST['btn_desactiver_multiple']) && isset($_POST['userCheckbox'])) {
                    $success = true;
                    foreach ($_POST['userCheckbox'] as $id) {
                        if (!$this->utilisateur->desactiverUtilisateur($id)) {
                            $success = false;
                            break;
                        }
                    }
                    $messageSuccess = $success ? 
                        "Utilisateurs désactivés avec succès." : 
                        "Erreur lors de la désactivation des utilisateurs.";
                }
            }

        } catch (Exception $e) {
            $messageErreur = "Erreur : " . $e->getMessage();
        }

        // Préparation des données pour la vue
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
        $GLOBALS['utilisateurs'] = $this->utilisateur->getAllUtilisateurs();
        $GLOBALS['types_utilisateur'] = $this->typeUtilisateur->getAllTypeUtilisateur();
        $GLOBALS['groupes_utilisateur'] = $this->groupeUtilisateur->getAllGroupeUtilisateur();
        $GLOBALS['niveau_acces'] = $this->niveauAcces->getAllNiveauxAccesDonnees();
        $GLOBALS['utilisateur_a_modifier'] = $utilisateur_a_modifier;
        $GLOBALS['action'] = $action;
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

    function construireMessageHTML($nom, $login, $motDePasse)
    {
        // Construction du sujet
        $sujet = "Bienvenue sur Soutenance Manager, " . htmlspecialchars($nom) . " !";

        // Construction du corps du message HTML
        $message = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Bienvenue</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #10b981; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background-color: #f9fafb; }
                .footer { margin-top: 20px; padding: 10px; text-align: center; font-size: 12px; color: #6b7280; }
                .button {
                    display: inline-block; padding: 10px 20px; background-color: #10b981; 
                    color: white; text-decoration: none; border-radius: 5px; margin: 15px 0;
                }
                .credentials { background-color: #e5e7eb; padding: 15px; border-radius: 5px; margin: 15px 0; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1> '.htmlspecialchars($sujet).'</h1>
                </div>
                
                <div class="content">
                    <p>Bonjour ' . htmlspecialchars($nom) . ',</p>
                    <p>Votre compte a été créé avec succès sur notre plateforme.</p>
                    
                    <div class="credentials">
                        <p><strong>Identifiant de connexion:</strong> ' . htmlspecialchars($login) . '</p>';
        
                      // Ajout du mot de passe temporaire si fourni
                   if ($motDePasse) {
                $message .= '<p><strong>Mot de passe temporaire:</strong> ' . htmlspecialchars($motDePasse) . '</p>
                        <p style="color: #ef4444; font-size: 0.9em;">
                            Pour des raisons de sécurité, nous vous recommandons de changer ce mot de passe après votre première connexion.
                        </p>';
                      }
        
                $message .= '
                    </div>
                    
                    <p>Vous pouvez dès maintenant vous connecter à votre compte :</p>
                    <a href="http://localhost:8080/page_connexion.php" class="button " style="color:#fff">Se connecter</a>
                    
                    <p>Si vous n\'êtes pas à l\'origine de cette création de compte, veuillez ignorer cet email ou contacter notre support.</p>
                </div>
                
                <div class="footer">
                    <p>© ' . date('Y') . ' Soutenance Manager. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>';


        return $message;
    }


    function envoyerEmailInscriptionPHPMailer($email, $nom, $login, $motDePasse)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->SMTPDebug = 2; // Active le débogage détaillé
            $mail->Debugoutput = function($str, $level) {
                error_log("PHPMailer Debug: $str");
            };
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'oceanetl27@gmail.com';
            $mail->Password = 'uuzxaeevsqicdxol';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Destinataires
            $mail->setFrom('oceanetl27@gmail.com', 'Soutenance Manager'); // Utiliser une adresse email valide
            $mail->addAddress($email, $nom);
            $mail->addReplyTo('oceanetl27@gmail.com', 'Support technique');

            // Contenu
            $mail->isHTML(true);
            $mail->Subject = "Bienvenue sur notre plateforme, $nom !";

            // Construction du message HTML
            $message = $this->construireMessageHTML($nom, $login, $motDePasse);
            $mail->Body = $message;
            $mail->AltBody = strip_tags($message);

            error_log("Tentative d'envoi d'email à : " . $email);
            $result = $mail->send();
            error_log("Email envoyé avec succès à : " . $email);
            return true;
        } catch (Exception $e) {
            error_log("Erreur PHPMailer détaillée: " . $e->getMessage());
            error_log("Erreur PHPMailer: {$mail->ErrorInfo}");
            return false;
        }
    }

    private function getUserInfo($type, $id) {
        switch ($type) {
            case 'etudiant':
                require_once __DIR__ . "/../models/Etudiants.php";
                $etudiantModel = new Etudiants(Database::getConnection());
                $etudiant = $etudiantModel->getEtudiantById($id);
                if ($etudiant) {
                    return [
                        'nom' => $etudiant->nom_etu,
                        'prenom' => $etudiant->prenom_etu,
                        'email' => $etudiant->login_etu
                    ];
                }
                break;
            case 'enseignant':
                require_once __DIR__ . "/../models/Enseignant.php";
                $enseignantModel = new Enseignant(Database::getConnection());
                $enseignant = $enseignantModel->getEnseignantById($id);
                if ($enseignant) {
                    return [
                        'nom' => $enseignant->nom_enseignant,
                        'prenom' => $enseignant->prenom_enseignant,
                        'email' => $enseignant->email_enseignant
                    ];
                }
                break;
            case 'pers_admin':
                require_once __DIR__ . "/../models/PersAdmin.php";
                $persAdminModel = new PersAdmin(Database::getConnection());
                $persAdmin = $persAdminModel->getPersAdminById($id);
                if ($persAdmin) {
                    return [
                        'nom' => $persAdmin->nom_pers_admin,
                        'prenom' => $persAdmin->prenom_pers_admin,
                        'email' => $persAdmin->email_pers_admin
                    ];
                }
                break;
        }
        return null;
    }

    private function getTypeUtilisateurId($type) {
        switch ($type) {
            case 'etudiant':
                return 7; // ID pour Etudiant
            case 'enseignant':
                return 6; // ID pour Enseignant simple
            case 'pers_admin':
                return 4; // ID pour Personnel administratif
            default:
                return null;
        }
    }

    private function sendWelcomeEmails($users) {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Remplacez par votre serveur SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'votre_email@gmail.com'; // Remplacez par votre email
            $mail->Password = 'votre_mot_de_passe'; // Remplacez par votre mot de passe
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            // Configuration de l'expéditeur
            $mail->setFrom('votre_email@gmail.com', 'Système de gestion');

            foreach ($users as $user) {
                $mail->clearAddresses();
                $mail->addAddress($user['email']);

                $mail->isHTML(true);
                $mail->Subject = 'Bienvenue sur la plateforme de gestion';
                $mail->Body = "
                    <h2>Bienvenue sur la plateforme de gestion</h2>
                    <p>Votre compte a été créé avec succès.</p>
                    <p>Voici vos identifiants de connexion :</p>
                    <ul>
                        <li>Email : {$user['email']}</li>
                        <li>Mot de passe : {$user['password']}</li>
                    </ul>
                    <p>Nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
                ";

                $mail->send();
            }
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi des emails : " . $e->getMessage());
        }
    }

}