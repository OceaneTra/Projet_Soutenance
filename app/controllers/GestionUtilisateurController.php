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

    private $typeConfig = [
        '1' => [
            'model' => 'Etudiants',
            'fields' => [
                'id' => 'num_etu',
                'nom' => 'nom_etu',
                'prenom' => 'prenom_etu',
                'email' => 'login_etu'
            ]
        ],
        '2' => [
            'model' => 'Enseignant',
            'fields' => [
                'id' => 'id_enseignant',
                'nom' => 'nom_enseignant',
                'prenom' => 'prenom_enseignant',
                'email' => 'mail_enseignant'
            ],
            'type' => 'simple'
        ],
        '3' => [
            'model' => 'Enseignant',
            'fields' => [
                'id' => 'id_enseignant',
                'nom' => 'nom_enseignant',
                'prenom' => 'prenom_enseignant',
                'email' => 'mail_enseignant'
            ],
            'type' => 'administratif'
        ],
        '4' => [
            'model' => 'PersAdmin',
            'fields' => [
                'id' => 'id_pers_admin',
                'nom' => 'nom_pers_admin',
                'prenom' => 'prenom_pers_admin',
                'email' => 'email_pers_admin'
            ]
        ]
    ];

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
        // Initialisation des variables globales
        $GLOBALS['utilisateur_a_modifier'] = null;
        $GLOBALS['utilisateurs'] = $this->utilisateur->getAllUtilisateurs();
        $GLOBALS['types_utilisateur'] = $this->typeUtilisateur->getAllTypeUtilisateur();
        $GLOBALS['groupes_utilisateur'] = $this->groupeUtilisateur->getAllGroupeUtilisateur();
        $GLOBALS['niveau_acces'] = $this->niveauAcces->getAllNiveauxAccesDonnees();
        $GLOBALS['messageErreur'] = '';
        $GLOBALS['messageSuccess'] = '';
        $GLOBALS['users_list'] = [];

        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        $selectedType = $_POST['type'] ?? $_GET['type'] ?? '';

        try {
            // Gestion des actions GET pour les modales
            if ($action === 'edit' && isset($_GET['id_utilisateur'])) {
                $GLOBALS['utilisateur_a_modifier'] = $this->utilisateur->getUtilisateurById($_GET['id_utilisateur']);
                if (!$GLOBALS['utilisateur_a_modifier']) {
                    $GLOBALS['messageErreur'] = "Utilisateur non trouvé.";
                }
            }
            // Gestion de l'affichage dynamique des utilisateurs selon le type
            else if ($action === 'get_users' && $selectedType) {
                $users = [];
                
                if (isset($this->typeConfig[$selectedType])) {
                    $config = $this->typeConfig[$selectedType];
                    $model = $this->loadUserModel($config['model']);
                    $fields = $config['fields'];
                    
                    $method = 'getAll' . $config['model'];
                    $allUsers = $model->$method();
                    
                    foreach ($allUsers as $user) {
                        // Pour les enseignants, vérifier le type
                        if ($config['model'] === 'Enseignant') {
                            $typeUtilisateur = $this->typeUtilisateur->getTypeUtilisateurById($selectedType);
                            if (!$typeUtilisateur || strpos($typeUtilisateur->lib_type_utilisateur, 'Enseignant') !== 0) {
                                continue;
                            }
                        }
                        
                        if (!$this->utilisateur->getUtilisateurByLogin($user->{$fields['email']})) {
                            $users[] = [
                                'id' => $user->{$fields['id']},
                                'nom' => $user->{$fields['nom']},
                                'prenom' => $user->{$fields['prenom']},
                                'email' => $user->{$fields['email']}
                            ];
                        }
                    }
                }
                
                $GLOBALS['users_list'] = $users;
                
                // Vérifier si c'est une requête AJAX
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'type' => 'usersList',
                        'content' => $this->renderUsersList($users)
                    ]);
                    exit;
                }
            
            // Gestion de l'ajout en masse des utilisateurs
            else if (isset($_POST['btn_add_bulk_users'])) {
                $selectedUsers = $_POST['selected_users'] ?? [];
                $id_GU = $_POST['id_GU'] ?? null;
                $id_type_utilisateur = $_POST['userType'] ?? '';

                error_log("ID Type d'utilisateur sélectionné : " . $id_type_utilisateur);

                if (empty($selectedUsers) || !$id_GU || !$id_type_utilisateur) {
                    $GLOBALS['messageErreur'] = "Veuillez sélectionner au moins un utilisateur et un groupe utilisateur.";
                } else {
                    $success = true;
                    $addedUsers = [];

                    foreach ($selectedUsers as $userId) {
                        // Récupérer le libellé du type d'utilisateur
                        $typeUtilisateurObj = $this->typeUtilisateur->getTypeUtilisateurById($id_type_utilisateur);
                        if (!$typeUtilisateurObj) {
                            $GLOBALS['messageErreur'] = "Type d'utilisateur non trouvé.";
                            continue;
                        }
                        
                        $userInfo = $this->getUserInfo($id_type_utilisateur, $userId);
                        if ($userInfo) {
                            // Générer un mot de passe aléatoire
                            $password = $this->generateRandomPassword();
                            $niveauAcces = $this->niveauAcces->getLastNiveauAccesDonnees();
                            
                            // Ajouter l'utilisateur
                            if ($this->utilisateur->ajouterUtilisateur(
                                $userInfo['nom'] . ' ' . $userInfo['prenom'],
                                $id_type_utilisateur,
                                $id_GU,
                                $niveauAcces->id_niveau_acces_donnees, // Niveau d'accès par défaut
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
                        $GLOBALS['messageSuccess'] = count($addedUsers) . " utilisateurs ont été ajoutés avec succès.";
                    } else {
                        $GLOBALS['messageErreur'] = "Une erreur est survenue lors de l'ajout des utilisateurs.";
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
                        $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
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
                            $GLOBALS['messageSuccess'] = $emailSent ? 
                                "Utilisateur ajouté avec succès et email envoyé." : 
                                "Utilisateur ajouté avec succès mais l'envoi de l'email a échoué.";
                        } else {
                            $GLOBALS['messageErreur'] = "Erreur lors de l'ajout de l'utilisateur.";
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
                        $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
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
                            $GLOBALS['messageSuccess'] = "Utilisateur modifié avec succès.";
                        } else {
                            $GLOBALS['messageErreur'] = "Erreur lors de la modification de l'utilisateur.";
                        }
                    }
                }

                // Désactivation d'un utilisateur
                if (isset($_POST['btn_desactiver_utilisateur'])) {
                    $id_utilisateur = $_POST['id_utilisateur'] ?? '';
                    if (empty($id_utilisateur)) {
                        $GLOBALS['messageErreur'] = "ID utilisateur manquant.";
                    } else {
                        if ($this->utilisateur->desactiverUtilisateur($id_utilisateur)) {
                            $GLOBALS['messageSuccess'] = "Utilisateur désactivé avec succès.";
                        } else {
                            $GLOBALS['messageErreur'] = "Erreur lors de la désactivation de l'utilisateur.";
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
                    $GLOBALS['messageSuccess'] = $success ? 
                        "Utilisateurs désactivés avec succès." : 
                        "Erreur lors de la désactivation des utilisateurs.";
                }
            }
        }

        } catch (Exception $e) {
            $GLOBALS['messageErreur'] = "Erreur : " . $e->getMessage();
        }
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

    private function loadUserModel($modelName) {
        require_once __DIR__ . "/../models/{$modelName}.php";
        return new $modelName(Database::getConnection());
    }

    private function getUserInfo($type, $id) {
        if (!isset($this->typeConfig[$type])) {
            return null;
        }

        $config = $this->typeConfig[$type];
        $model = $this->loadUserModel($config['model']);
        $fields = $config['fields'];

        $method = 'get' . $config['model'] . 'ById';
        $user = $model->$method($id);

        if (!$user) {
            return null;
        }

        return [
            'nom' => $user->{$fields['nom']},
            'prenom' => $user->{$fields['prenom']},
            'email' => $user->{$fields['email']}
        ];
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

    private function renderUsersList($users) {
        ob_start();
        if (empty($users)) {
            echo '<div class="text-center text-gray-500 py-4">
                    <i class="fas fa-users text-gray-300 text-4xl mb-2"></i>
                    <p>Aucun utilisateur disponible pour ce type.</p>
                  </div>';
        } else {
            foreach ($users as $user) {
                echo '<div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded">
                        <input type="checkbox" name="selected_users[]" value="' . htmlspecialchars($user['id']) . '" 
                               class="user-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">
                                ' . htmlspecialchars($user['nom'] . ' ' . $user['prenom']) . '
                            </div>
                            <div class="text-sm text-gray-500">
                                ' . htmlspecialchars($user['email']) . '
                            </div>
                        </div>
                      </div>';
            }
        }
        return ob_get_clean();
    }

}