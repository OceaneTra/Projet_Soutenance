<?php


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../models/Utilisateur.php";
require_once __DIR__ . "/../models/TypeUtilisateur.php";
require_once __DIR__ . "/../models/GroupeUtilisateur.php";
require_once __DIR__ . "/../models/NiveauAccesDonnees.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

/**
 * Contrôleur de gestion des utilisateurs
 * 
 * Ce contrôleur gère toutes les opérations liées aux utilisateurs :
 * - Ajout d'utilisateurs
 * - Modification d'utilisateurs
 * - Désactivation d'utilisateurs
 * - Envoi d'emails de bienvenue
 */
class GestionUtilisateurController
{
    /** @var Utilisateur */
    private $utilisateur;

    /** @var string */
    private $baseViewPath;

    /** @var TypeUtilisateur */
    private $typeUtilisateur;

    /** @var GroupeUtilisateur */
    private $groupeUtilisateur;

    /** @var NiveauAccesDonnees */
    private $niveauAcces;

    /** @var array Configuration des types d'utilisateurs */
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

    /** @var array Configuration du serveur SMTP */
    private $smtpConfig = [
        'host' => 'smtp.gmail.com',
        'username' => 'managersoutenance@gmail.com',
        'password' => 'iweglnpanhpkoqfe',
        'port' => 587,
        'encryption' => 'tls'
    ];

    /**
     * Constructeur du contrôleur
     * Initialise les modèles et les chemins nécessaires
     */
    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/';
        $this->utilisateur = new Utilisateur(Database::getConnection());
        $this->groupeUtilisateur = new GroupeUtilisateur(Database::getConnection());
        $this->typeUtilisateur = new TypeUtilisateur(Database::getConnection());
        $this->niveauAcces = new NiveauAccesDonnees(Database::getConnection());
    }

    /**
     * Point d'entrée principal du contrôleur
     * Gère toutes les actions liées aux utilisateurs
     */
    public function index()
    {
        $this->initializeGlobals();
        $action = $_POST['action'] ?? $_GET['action'] ?? '';
        $selectedType = $_POST['type'] ?? $_GET['type'] ?? '';

        try {
            if ($this->handleGetActions($action)) {
                return;
            }

            if ($this->handlePostActions()) {
                return;
            }

            if ($action === 'get_users' && $selectedType) {
                $this->handleGetUsersAction($selectedType);
            }
        } catch (Exception $e) {
            $GLOBALS['messageErreur'] = "Erreur : " . $e->getMessage();
        }
    }

    /**
     * Initialise les variables globales utilisées dans les vues
     */
    private function initializeGlobals()
    {
        $GLOBALS['utilisateur_a_modifier'] = null;
        $GLOBALS['utilisateurs'] = $this->utilisateur->getAllUtilisateurs();
        $GLOBALS['types_utilisateur'] = $this->typeUtilisateur->getAllTypeUtilisateur();
        $GLOBALS['groupes_utilisateur'] = $this->groupeUtilisateur->getAllGroupeUtilisateur();
        $GLOBALS['niveau_acces'] = $this->niveauAcces->getAllNiveauxAccesDonnees();
        $GLOBALS['messageErreur'] = '';
        $GLOBALS['messageSuccess'] = '';
        $GLOBALS['users_list'] = [];
    }

    /**
     * Gère les actions de type GET
     * 
     * @param string $action Action à effectuer
     * @return bool True si une action a été traitée
     */
    private function handleGetActions($action)
    {
        if ($action === 'edit' && isset($_GET['id_utilisateur'])) {
            $GLOBALS['utilisateur_a_modifier'] = $this->utilisateur->getUtilisateurById($_GET['id_utilisateur']);
            if (!$GLOBALS['utilisateur_a_modifier']) {
                $GLOBALS['messageErreur'] = "Utilisateur non trouvé.";
            }
            return true;
        }
        return false;
    }

    /**
     * Gère les actions de type POST
     * 
     * @return bool True si une action a été traitée
     */
    private function handlePostActions()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        if (isset($_POST['btn_add_utilisateur'])) {
            $this->handleAddUser();
            return true;
        }

        if (isset($_POST['btn_modifier_utilisateur'])) {
            $this->handleModifyUser();
            return true;
        }
        if (isset($_POST['update_password'])) {
            $this->handleModifyPassword();
            return true;
        }


        if (isset($_POST['btn_desactiver_utilisateur'])) {
            $this->handleDeactivateUser();
            return true;
        }

        if (isset($_POST['btn_desactiver_multiple']) && isset($_POST['userCheckbox'])) {
            $this->handleDeactivateMultipleUsers();
            return true;
        }

        if (isset($_POST['btn_add_bulk_users'])) {
            $this->handleBulkAddUsers();
            return true;
        }

        return false;
    }


    private function handleModifyPassword() {
        if (empty($_POST['currentPassword']) || empty($_POST['newPassword']) || empty($_POST['confirmPassword'])) {
            $_SESSION['password_error'] = "Tous les champs sont obligatoires.";
            return;
        }

        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
        $id_utilisateur = $_POST['id_utilisateur'];

        if ($newPassword !== $confirmPassword) {
            $_SESSION['password_error'] = "Les mots de passe ne correspondent pas.";
            return;
        }

        if (strlen($newPassword) < 8) { 
            $_SESSION['password_error'] = "Le mot de passe doit contenir au moins 8 caractères.";
            return;
        }

        $utilisateur = $this->utilisateur->getUtilisateurById($id_utilisateur);
        if (!$utilisateur || !isset($utilisateur->mdp_utilisateur) || empty($utilisateur->mdp_utilisateur)) {
            $_SESSION['password_error'] = "Impossible de récupérer les informations de l'utilisateur.";
            return;
        }

        if (!password_verify($currentPassword, $utilisateur->mdp_utilisateur)) {
            $_SESSION['password_error'] = "Le mot de passe actuel est incorrect.";
            return; 
        }
            

        if ($this->utilisateur->updatePassword($id_utilisateur, password_hash($newPassword, PASSWORD_DEFAULT))) {
            $_SESSION['password_success'] = "Mot de passe modifié avec succès.";
        } else {
            $_SESSION['password_error'] = "Erreur lors de la modification du mot de passe.";
        }   
    }

    /**
     * Gère l'ajout d'un nouvel utilisateur
     */
    private function handleAddUser()
    {
        $requiredFields = ['nom_utilisateur', 'id_type_utilisateur', 'id_GU', 'login_utilisateur', 'statut_utilisateur', 'id_niveau_acces'];
        
        if (!$this->validateRequiredFields($requiredFields)) {
            $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
            return;
        }

        $mdp = $this->generateRandomPassword();
        if ($this->utilisateur->ajouterUtilisateur(
            $_POST['nom_utilisateur'],
            $_POST['id_type_utilisateur'],
            $_POST['id_GU'],
            $_POST['id_niveau_acces'],
            $_POST['statut_utilisateur'],
            $_POST['login_utilisateur'],
            password_hash($mdp, PASSWORD_DEFAULT)
        )) {
            $this->sendWelcomeEmails([[
                'email' => $_POST['login_utilisateur'],
                'nom' => $_POST['nom_utilisateur'],
                'mdp' => $mdp
            ]]);
            $GLOBALS['messageSuccess'] = "Utilisateur ajouté avec succès et email envoyé.";
        } else {
            $GLOBALS['messageErreur'] = "Erreur lors de l'ajout de l'utilisateur.";
        }
    }

    /**
     * Gère la modification d'un utilisateur
     */
    private function handleModifyUser()
    {
        $requiredFields = ['id_utilisateur', 'nom_utilisateur', 'id_type_utilisateur', 'id_GU', 'login_utilisateur', 'statut_utilisateur', 'id_niveau_acces'];
        
        if (!$this->validateRequiredFields($requiredFields)) {
            $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
            return;
        }

        if ($this->utilisateur->updateUtilisateur(
            $_POST['nom_utilisateur'],
            $_POST['id_type_utilisateur'],
            $_POST['id_GU'],
            $_POST['id_niveau_acces'],
            $_POST['statut_utilisateur'],
            $_POST['login_utilisateur'],
            $_POST['id_utilisateur']
        )) {
            $GLOBALS['messageSuccess'] = "Utilisateur modifié avec succès.";
        } else {
            $GLOBALS['messageErreur'] = "Erreur lors de la modification de l'utilisateur.";
        }
    }

    /**
     * Gère la désactivation d'un utilisateur
     */
    private function handleDeactivateUser()
    {
        if (empty($_POST['id_utilisateur'])) {
            $GLOBALS['messageErreur'] = "ID utilisateur manquant.";
            return;
        }

        if ($this->utilisateur->desactiverUtilisateur($_POST['id_utilisateur'])) {
            $GLOBALS['messageSuccess'] = "Utilisateur désactivé avec succès.";
        } else {
            $GLOBALS['messageErreur'] = "Erreur lors de la désactivation de l'utilisateur.";
        }
    }

    /**
     * Gère la désactivation multiple d'utilisateurs
     */
    private function handleDeactivateMultipleUsers()
    {
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

    /**
     * Gère l'ajout en masse d'utilisateurs
     */
    private function handleBulkAddUsers()
    {
        $selectedUsers = $_POST['selected_users'] ?? [];
        $id_GU = $_POST['id_GU'] ?? null;
        $id_type_utilisateur = $_POST['userType'] ?? '';

        if (empty($selectedUsers) || !$id_GU || !$id_type_utilisateur) {
            $GLOBALS['messageErreur'] = "Veuillez sélectionner au moins un utilisateur et un groupe utilisateur.";
            return;
        }

        $success = true;
        $addedUsers = [];

        foreach ($selectedUsers as $userId) {
            $typeUtilisateurObj = $this->typeUtilisateur->getTypeUtilisateurById($id_type_utilisateur);
            if (!$typeUtilisateurObj) {
                $GLOBALS['messageErreur'] = "Type d'utilisateur non trouvé.";
                continue;
            }
            
            $userInfo = $this->getUserInfo($id_type_utilisateur, $userId);
            if ($userInfo) {
                $password = $this->generateRandomPassword();
                $niveauAcces = $this->niveauAcces->getLastNiveauAccesDonnees();
                
                if ($this->utilisateur->ajouterUtilisateur(
                    $userInfo['nom'] . ' ' . $userInfo['prenom'],
                    $id_type_utilisateur,
                    $id_GU,
                    $niveauAcces->id_niveau_acces_donnees,
                    'Actif',
                    $userInfo['email'],
                    password_hash($password, PASSWORD_DEFAULT)
                )) {
                    $addedUsers[] = [
                        'email' => $userInfo['email'],
                        'nom' => $userInfo['nom'] . ' ' . $userInfo['prenom'],
                        'mdp' => $password
                    ];
                } else {
                    $success = false;
                }
            }
        }

        if ($success) {
            $this->sendWelcomeEmails($addedUsers);
            $GLOBALS['messageSuccess'] = count($addedUsers) . " utilisateurs ont été ajoutés avec succès.";
        } else {
            $GLOBALS['messageErreur'] = "Une erreur est survenue lors de l'ajout des utilisateurs.";
        }
    }

    /**
     * Gère l'action de récupération des utilisateurs
     * 
     * @param string $selectedType Type d'utilisateur sélectionné
     */
    private function handleGetUsersAction($selectedType)
    {
        $users = [];
        
        if (isset($this->typeConfig[$selectedType])) {
            $config = $this->typeConfig[$selectedType];
            $model = $this->loadUserModel($config['model']);
            $fields = $config['fields'];
            
            $method = 'getAll' . $config['model'];
            $allUsers = $model->$method();
            
            foreach ($allUsers as $user) {
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
        
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'type' => 'usersList',
                'content' => $this->renderUsersList($users)
            ]);
            exit;
        }
    }

    /**
     * Vérifie que tous les champs requis sont présents
     * 
     * @param array $fields Liste des champs requis
     * @return bool True si tous les champs sont présents
     */
    private function validateRequiredFields($fields)
    {
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Génère un mot de passe aléatoire sécurisé
     * 
     * @param int $length Longueur du mot de passe
     * @return string Mot de passe généré
     */
    private function generateRandomPassword($length = 12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }

    /**
     * Construit le message HTML pour l'email de bienvenue
     * 
     * @param string $nom Nom de l'utilisateur
     * @param string $login Login de l'utilisateur
     * @param string|null $motDePasse Mot de passe temporaire
     * @return string Message HTML formaté
     */
    private function construireMessageHTML($nom, $login, $motDePasse = null)
    {
        // Construction du sujet
        $sujet = "Bienvenue sur Soutenance Manager, " . htmlspecialchars($nom ?? '') . " !";

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
                    <h1>'.htmlspecialchars($sujet).'</h1>
                </div>
                
                <div class="content">
                    <p>Bonjour ' . htmlspecialchars($nom ?? '') . ',</p>
                    <p>Votre compte a été créé avec succès sur notre plateforme.</p>
                    
                    <div class="credentials">
                        <p><strong>Identifiant de connexion:</strong> ' . htmlspecialchars($login ?? '') . '</p>';
        
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
                    <a href="http://localhost:8080/page_connexion.php" class="button" style="color:#fff">Se connecter</a>
                    
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

    /**
     * Charge le modèle d'utilisateur approprié
     * 
     * @param string $modelName Nom du modèle à charger
     * @return object Instance du modèle
     * @throws Exception Si le modèle n'existe pas
     */
    private function loadUserModel($modelName) 
    {
        $modelPath = __DIR__ . "/../models/{$modelName}.php";
        if (!file_exists($modelPath)) {
            throw new Exception("Le modèle {$modelName} n'existe pas");
        }
        require_once $modelPath;
        return new $modelName(Database::getConnection());
    }

    /**
     * Récupère les informations d'un utilisateur selon son type
     * 
     * @param string $type Type d'utilisateur
     * @param int $id Identifiant de l'utilisateur
     * @return array|null Informations de l'utilisateur ou null si non trouvé
     */
    private function getUserInfo($type, $id) 
    {
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

    /**
     * Envoie les emails de bienvenue aux nouveaux utilisateurs
     * 
     * @param array $users Liste des utilisateurs à notifier
     * @return bool Succès de l'opération
     */
    private function sendWelcomeEmails($users) 
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->isSMTP();
            $mail->Host = $this->smtpConfig['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtpConfig['username'];
            $mail->Password = $this->smtpConfig['password'];
            $mail->SMTPSecure = $this->smtpConfig['encryption'];
            $mail->Port = $this->smtpConfig['port'];
            $mail->CharSet = 'UTF-8';

            // Configuration de l'expéditeur
            $mail->setFrom($this->smtpConfig['username'], 'Système de gestion');

            foreach ($users as $user) {
                // Vérification des données requises
                if (empty($user['email']) || empty($user['nom'])) {
                    error_log("Données utilisateur manquantes pour l'envoi d'email");
                    continue;
                }

                $mail->clearAddresses();
                $mail->addAddress($user['email']);

                $mail->isHTML(true);
                $mail->Subject = 'Bienvenue sur Soutenance Manager ' . $user['nom'];
                $mail->Body = $this->construireMessageHTML($user['nom'], $user['email'], $user['mdp'] ?? null);
                $mail->send();
            }
            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'envoi des emails : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Génère le HTML pour la liste des utilisateurs
     * 
     * @param array $users Liste des utilisateurs à afficher
     * @return string HTML généré
     */
    private function renderUsersList($users) 
    {
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