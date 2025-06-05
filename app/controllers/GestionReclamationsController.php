<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Reclamation.php';

class GestionReclamationsController {

    private $baseViewPath;
    private $reclamationModel;

    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/gestion_reclamations/';
        $this->reclamationModel = new Reclamation();

        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            header('Location: page_connexion.php');
            exit;
        }

        // Adapter les variables selon votre système d'authentification existant
        $_SESSION['user_id'] = $this->determinerUserId();
        $_SESSION['user_type'] = $this->determinerTypeUtilisateur();
        $_SESSION['groupe_utilisateur'] = $_SESSION['id_GU'] ?? 13;
    }

    private function determinerUserId() {
        // Pour les étudiants, utiliser num_etu, sinon id_utilisateur
        if (isset($_SESSION['num_etu'])) {
            return $_SESSION['num_etu'];
        }
        return $_SESSION['id_utilisateur'];
    }

    private function determinerTypeUtilisateur()
    {
        // Utiliser le type d'utilisateur déjà déterminé par votre AuthController
        $typeUtilisateur = $_SESSION['type_utilisateur'] ?? '';

        // Mapper vers les types utilisés dans le système de réclamations
        if ($typeUtilisateur === 'Etudiant') {
            return 'etudiant';
        }

        // Tous les autres types sont considérés comme administratifs
        if (in_array($typeUtilisateur, [
            'Personnel administratif',
            'Enseignant simple',
            'Enseignant administratif'
        ])) {
            return 'admin';
        }

        return 'etudiant'; // Par défaut
    }

    // Afficher le dashboard des réclamations
    public function index()
    {
        try {
            // Récupérer les statistiques pour usage dans la vue
            global $statistiquesReclamations, $reclamationsRecentes;

            $statistiquesReclamations = $this->reclamationModel->getStatistiques();
            $reclamationsRecentes = $this->reclamationModel->getTous(5, 0);

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement du dashboard : " . $e->getMessage());
        }
    }

    //=============================SOUMETTRE RECLAMATION=============================
    public function soumettreReclamations()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->traiterSoumissionReclamation();
        } else {
            // Préparer les données pour la vue
            global $typesReclamation, $erreurs;

            $typesReclamation = [
                'academic' => 'Problème académique',
                'administrative' => 'Problème administratif',
                'technical' => 'Problème technique',
                'financial' => 'Problème financier',
                'other' => 'Autre'
            ];

            $erreurs = $_SESSION['erreurs_form'] ?? [];
            unset($_SESSION['erreurs_form']);
        }
    }

    private function traiterSoumissionReclamation()
    {
        try {
            // Debug : afficher les données reçues
            error_log("POST data: " . print_r($_POST, true));
            error_log("SESSION data: " . print_r($_SESSION, true));

            // Récupérer les données du formulaire
            $donneesReclamation = [
                'titre' => $_POST['objet'] ?? '',
                'description' => $_POST['content'] ?? '',
                'type' => $this->mapTypeFromForm($_POST['type'] ?? ''),
                'priorite' => 'Moyenne' // Par défaut
            ];

            // Validation des données
            $erreurs = $this->validerDonneesReclamation($donneesReclamation);

            if (!empty($erreurs)) {
                $_SESSION['erreurs_form'] = $erreurs;
                header('Location: ?page=gestion_reclamations&action=soumettre_reclamation');
                exit;
            }

            // Gestion du fichier joint (si présent)
            $fichierJoint = null;
            if (isset($_FILES['fichier_joint']) && $_FILES['fichier_joint']['error'] === UPLOAD_ERR_OK) {
                $fichierJoint = $this->gererUploadFichier($_FILES['fichier_joint']);
            }

            // Préparer les données pour la base selon le type d'utilisateur
            if ($_SESSION['user_type'] === 'etudiant') {
                // Pour les étudiants, utiliser num_etu
                if (!isset($_SESSION['num_etu'])) {
                    // Tentative de récupération via l'email si pas trouvé
                    $this->recupererNumEtu();

                    if (!isset($_SESSION['num_etu'])) {
                        throw new Exception("Impossible de récupérer votre numéro d'étudiant. Veuillez vous reconnecter.");
                    }
                }

                $donnees = [
                    'num_etu' => $_SESSION['num_etu'],
                    'id_utilisateur' => null,
                    'titre' => trim($donneesReclamation['titre']),
                    'description' => strip_tags(trim($donneesReclamation['description'])),
                    'type' => $donneesReclamation['type'],
                    'priorite' => $donneesReclamation['priorite'],
                    'fichier' => $fichierJoint
                ];
            } else {
                // Pour le personnel/enseignants, utiliser id_utilisateur
                $donnees = [
                    'num_etu' => null,
                    'id_utilisateur' => $_SESSION['id_utilisateur'],
                    'titre' => trim($donneesReclamation['titre']),
                    'description' => strip_tags(trim($donneesReclamation['description'])),
                    'type' => $donneesReclamation['type'],
                    'priorite' => $donneesReclamation['priorite'],
                    'fichier' => $fichierJoint
                ];
            }

            // Debug : afficher les données préparées
            error_log("Données pour insertion: " . print_r($donnees, true));

            // Créer la réclamation
            $reclamationId = $this->reclamationModel->creer($donnees);

            if ($reclamationId) {
                $this->afficherMessage('Réclamation soumise avec succès. Numéro de référence : REC-' . $reclamationId, 'success');
                header('Location: ?page=gestion_reclamations');
                exit;
            } else {
                $this->afficherMessage('Erreur lors de la soumission de la réclamation. Veuillez réessayer.', 'error');
                header('Location: ?page=gestion_reclamations&action=soumettre_reclamation');
                exit;
            }

        } catch (Exception $e) {
            error_log("Exception dans traiterSoumissionReclamation: " . $e->getMessage());
            $this->afficherMessage("Erreur lors de la soumission : " . $e->getMessage(), 'error');
            header('Location: ?page=gestion_reclamations&action=soumettre_reclamation');
            exit;
        }
    }

    private function recupererNumEtu() {
        try {
            if (!isset($_SESSION['login_utilisateur'])) {
                return false;
            }

            $db = Database::getConnection();
            $query = "SELECT num_etu FROM etudiants WHERE email_etu = :email";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':email', $_SESSION['login_utilisateur']);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $_SESSION['num_etu'] = $result['num_etu'];
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération du num_etu: " . $e->getMessage());
            return false;
        }
    }

    private function mapTypeFromForm($type) {
        $map = [
            'academic' => 'Académique',
            'administrative' => 'Administrative',
            'technical' => 'Technique',
            'financial' => 'Financière',
            'other' => 'Autre'
        ];
        return $map[$type] ?? 'Autre';
    }

    private function validerDonneesReclamation($donnees)
    {
        $erreurs = [];

        if (empty($donnees['titre']) || strlen(trim($donnees['titre'])) < 5) {
            $erreurs['titre'] = 'Le titre doit contenir au moins 5 caractères.';
        }

        if (empty($donnees['description']) || strlen(strip_tags(trim($donnees['description']))) < 20) {
            $erreurs['description'] = 'La description doit contenir au moins 20 caractères.';
        }

        if (empty($donnees['type']) || !in_array($donnees['type'], ['Académique', 'Administrative', 'Technique', 'Financière', 'Autre'])) {
            $erreurs['type'] = 'Veuillez sélectionner un type de réclamation valide.';
        }

        return $erreurs;
    }

    private function gererUploadFichier($fichier)
    {
        $dossierUpload = __DIR__ . '/../../ressources/uploads/reclamations/';

        // Créer le dossier s'il n'existe pas
        if (!is_dir($dossierUpload)) {
            if (!mkdir($dossierUpload, 0755, true)) {
                throw new Exception('Impossible de créer le dossier d\'upload.');
            }
        }

        // Vérifier que le dossier est accessible en écriture
        if (!is_writable($dossierUpload)) {
            throw new Exception('Le dossier d\'upload n\'est pas accessible en écriture.');
        }

        // Générer un nom unique
        $extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
        $nomFichier = 'rec_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $extension;
        $cheminComplet = $dossierUpload . $nomFichier;

        // Vérifier le type de fichier
        $typesAutorises = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'txt'];
        if (!in_array(strtolower($extension), $typesAutorises)) {
            throw new Exception('Type de fichier non autorisé. Types acceptés : ' . implode(', ', $typesAutorises));
        }

        // Vérifier la taille (5MB max)
        if ($fichier['size'] > 5 * 1024 * 1024) {
            throw new Exception('Le fichier est trop volumineux (5MB maximum).');
        }

        if (move_uploaded_file($fichier['tmp_name'], $cheminComplet)) {
            return $nomFichier;
        } else {
            throw new Exception('Erreur lors du téléchargement du fichier.');
        }
    }

    //=============================SUIVI RECLAMATION=============================
    public function suiviReclamations()
    {
        try {
            global $reclamations, $statistiques, $totalPages, $page, $totalReclamations, $filtresActuels;

            $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Filtres
            $filtres = [];
            if (isset($_GET['status']) && $_GET['status'] !== 'all') {
                $statusMap = [
                    'pending' => 'En attente',
                    'in_progress' => 'En cours',
                    'resolved' => 'Résolue',
                    'rejected' => 'Rejetée'
                ];
                if (isset($statusMap[$_GET['status']])) {
                    $filtres['statut'] = $statusMap[$_GET['status']];
                }
            }

            if (isset($_GET['type']) && $_GET['type'] !== 'all') {
                $typeMap = [
                    'academic' => 'Académique',
                    'administrative' => 'Administrative',
                    'technical' => 'Technique',
                    'financial' => 'Financière'
                ];
                if (isset($typeMap[$_GET['type']])) {
                    $filtres['type'] = $typeMap[$_GET['type']];
                }
            }

            // Récupérer les réclamations selon le type d'utilisateur
            if ($_SESSION['user_type'] === 'etudiant') {
                // Pour les étudiants, filtrer par num_etu
                $reclamations = $this->reclamationModel->getParUtilisateur($_SESSION['num_etu'], 'etudiant');
                $totalReclamations = count($reclamations);

                // Appliquer les filtres manuellement pour les étudiants
                if (!empty($filtres)) {
                    $reclamations = array_filter($reclamations, function($rec) use ($filtres) {
                        if (isset($filtres['statut']) && $rec['statut_reclamation'] !== $filtres['statut']) {
                            return false;
                        }
                        if (isset($filtres['type']) && $rec['type_reclamation'] !== $filtres['type']) {
                            return false;
                        }
                        return true;
                    });
                }

                $reclamations = array_slice($reclamations, $offset, $limit);
            } else {
                // Pour les administrateurs/enseignants, voir toutes les réclamations
                $reclamations = $this->reclamationModel->getTous($limit, $offset, $filtres);
                $totalReclamations = $this->reclamationModel->compterTotal($filtres);
            }

            $totalPages = ceil($totalReclamations / $limit);

            // Calculer les statistiques
            $statistiques = $this->calculerStatistiques();

            // Données pour la vue
            $filtresActuels = $_GET;

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement du suivi : " . $e->getMessage());
        }
    }

    private function calculerStatistiques()
    {
        if ($_SESSION['user_type'] === 'etudiant') {
            $reclamations = $this->reclamationModel->getParUtilisateur($_SESSION['num_etu'], 'etudiant');
        } else {
            $reclamations = $this->reclamationModel->getTous(1000, 0); // Grande limite
        }

        $stats = [
            'total' => count($reclamations),
            'pending' => 0,
            'in_progress' => 0,
            'resolved' => 0
        ];

        foreach ($reclamations as $rec) {
            switch ($rec['statut_reclamation']) {
                case 'En attente':
                    $stats['pending']++;
                    break;
                case 'En cours':
                    $stats['in_progress']++;
                    break;
                case 'Résolue':
                    $stats['resolved']++;
                    break;
            }
        }

        return $stats;
    }

    //=============================HISTORIQUE RECLAMATION=============================
    public function historiqueReclamations()
    {
        try {
            // Si un ID est spécifié, afficher le détail
            if (isset($_GET['id'])) {
                $this->afficherDetailReclamation($_GET['id']);
                return;
            }

            global $reclamations, $statistiquesHistorique, $totalPages, $page, $totalReclamations, $filtresActuels;

            $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Filtres
            $filtres = [];
            if (isset($_GET['status']) && $_GET['status'] !== 'all') {
                $statusMap = [
                    'en-cours' => ['En attente', 'En cours'],
                    'resolue' => 'Résolue',
                    'sans-suite' => 'Rejetée'
                ];

                if (isset($statusMap[$_GET['status']])) {
                    if (is_array($statusMap[$_GET['status']])) {
                        // Pour 'en-cours', on cherche soit 'En attente' soit 'En cours'
                        $filtres['statut_multiple'] = $statusMap[$_GET['status']];
                    } else {
                        $filtres['statut'] = $statusMap[$_GET['status']];
                    }
                }
            }

            // Récupérer les données selon le type d'utilisateur
            if ($_SESSION['user_type'] === 'etudiant') {
                $reclamations = $this->reclamationModel->getParUtilisateur($_SESSION['num_etu'], 'etudiant');
                $totalReclamations = count($reclamations);

                // Appliquer les filtres manuellement
                if (!empty($filtres)) {
                    $reclamations = array_filter($reclamations, function($rec) use ($filtres) {
                        if (isset($filtres['statut']) && $rec['statut_reclamation'] !== $filtres['statut']) {
                            return false;
                        }
                        if (isset($filtres['statut_multiple']) && !in_array($rec['statut_reclamation'], $filtres['statut_multiple'])) {
                            return false;
                        }
                        return true;
                    });
                }

                // Trier par date (plus récentes en premier)
                usort($reclamations, function($a, $b) {
                    return strtotime($b['date_creation']) - strtotime($a['date_creation']);
                });

                $reclamations = array_slice($reclamations, $offset, $limit);
            } else {
                $reclamations = $this->reclamationModel->getTous($limit, $offset, $filtres);
                $totalReclamations = $this->reclamationModel->compterTotal($filtres);
            }

            $totalPages = ceil($totalReclamations / $limit);

            // Calculer les statistiques pour l'historique
            $statistiquesHistorique = $this->calculerStatistiquesHistorique();

            // Données pour la vue
            $filtresActuels = $_GET;

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement de l'historique : " . $e->getMessage());
        }
    }

    private function calculerStatistiquesHistorique()
    {
        if ($_SESSION['user_type'] === 'etudiant') {
            $reclamations = $this->reclamationModel->getParUtilisateur($_SESSION['num_etu'], 'etudiant');
        } else {
            $reclamations = $this->reclamationModel->getTous(1000, 0);
        }

        $stats = [
            'en_cours' => 0,
            'resolues' => 0,
            'sans_suite' => 0
        ];

        foreach ($reclamations as $rec) {
            switch ($rec['statut_reclamation']) {
                case 'En attente':
                case 'En cours':
                    $stats['en_cours']++;
                    break;
                case 'Résolue':
                    $stats['resolues']++;
                    break;
                case 'Rejetée':
                    $stats['sans_suite']++;
                    break;
            }
        }

        return $stats;
    }

    private function afficherDetailReclamation($id)
    {
        global $reclamation, $historique;

        $reclamation = $this->reclamationModel->getParId($id);

        if (!$reclamation) {
            $this->afficherErreur("Réclamation non trouvée.");
            return;
        }

        // Vérifier les droits d'accès
        if ($_SESSION['user_type'] === 'etudiant' && $reclamation['num_etu'] != $_SESSION['num_etu']) {
            $this->afficherErreur("Accès non autorisé.");
            return;
        }

        $historique = $this->reclamationModel->getHistorique($id);

        // Forcer l'inclusion de la vue de détail
        $contentFile = $this->baseViewPath . 'detail_reclamation.php';
        if (file_exists($contentFile)) {
            include $contentFile;
        } else {
            $this->afficherErreur("Vue de détail non trouvée.");
        }
        exit; // Empêcher l'affichage de la vue normale
    }

    //=============================ACTIONS ADMINISTRATIVES=============================
    public function traiterReclamation()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->afficherErreur("Méthode non autorisée.");
            return;
        }

        try {
            $id = $_POST['id_reclamation'];
            $action = $_POST['action'];
            $commentaire = trim($_POST['commentaire'] ?? '');

            switch ($action) {
                case 'prendre_en_charge':
                    $this->prendreEnCharge($id, $commentaire);
                    break;
                case 'resoudre':
                    $this->resoudreReclamation($id, $commentaire);
                    break;
                case 'rejeter':
                    $this->rejeterReclamation($id, $commentaire);
                    break;
                default:
                    $this->afficherErreur("Action non reconnue.");
                    return;
            }

            $this->afficherMessage("Action effectuée avec succès.", 'success');

            // Rediriger vers la page de détail ou de suivi
            header("Location: ?page=gestion_reclamations&action=historique_reclamation&id=" . $id);
            exit;
        } catch (Exception $e) {
            $this->afficherMessage("Erreur lors du traitement : " . $e->getMessage(), 'error');
            header("Location: ?page=gestion_reclamations&action=suivi_reclamation");
            exit;
        }
    }

    private function prendreEnCharge($id, $commentaire)
    {
        return $this->reclamationModel->mettreAJourStatut($id, 'En cours', $commentaire, $_SESSION['id_utilisateur']);
    }

    private function resoudreReclamation($id, $commentaire)
    {
        if (empty($commentaire)) {
            throw new Exception("Un commentaire est requis pour résoudre une réclamation.");
        }
        return $this->reclamationModel->mettreAJourStatut($id, 'Résolue', $commentaire, $_SESSION['id_utilisateur']);
    }

    private function rejeterReclamation($id, $commentaire)
    {
        if (empty($commentaire)) {
            throw new Exception("Un commentaire est requis pour rejeter une réclamation.");
        }
        return $this->reclamationModel->mettreAJourStatut($id, 'Rejetée', $commentaire, $_SESSION['id_utilisateur']);
    }

    //=============================MÉTHODES UTILITAIRES=============================
    private function afficherMessage($message, $type = 'info')
    {
        $_SESSION['message'] = ['text' => $message, 'type' => $type];
    }

    private function afficherErreur($message)
    {
        $this->afficherMessage($message, 'error');
        include $this->baseViewPath . 'erreur.php';
    }

    private function verifierDroitsAdmin()
    {
        $groupesAdmin = [5, 6, 7, 8]; // Admins, secrétaires, etc.
        return in_array($_SESSION['groupe_utilisateur'] ?? 0, $groupesAdmin);
    }

    public function exporterReclamations()
    {
        if (!$this->verifierDroitsAdmin()) {
            $this->afficherErreur("Accès non autorisé.");
            return;
        }

        try {
            $reclamations = $this->reclamationModel->getTous(1000, 0); // Limite élevée pour export

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=reclamations_' . date('Y-m-d') . '.csv');

            $output = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($output, [
                'ID', 'Titre', 'Type', 'Statut', 'Priorité',
                'Date création', 'Demandeur', 'Admin assigné'
            ]);

            // Données
            foreach ($reclamations as $rec) {
                fputcsv($output, [
                    $rec['id_reclamation'],
                    $rec['titre_reclamation'],
                    $rec['type_reclamation'],
                    $rec['statut_reclamation'],
                    $rec['priorite_reclamation'],
                    $rec['date_creation'],
                    $rec['nom_etu'] ?? $rec['nom_utilisateur'],
                    $rec['nom_admin_assigne']
                ]);
            }

            fclose($output);
        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors de l'export : " . $e->getMessage());
        }
    }

    private function verifierDroitsAcces($reclamation)
    {
        if ($_SESSION['user_type'] === 'etudiant') {
            // Un étudiant ne peut voir que ses propres réclamations
            return $reclamation['num_etu'] == $_SESSION['num_etu'];
        } else {
            // Le personnel administratif peut voir toutes les réclamations
            return true;
        }
    }
}