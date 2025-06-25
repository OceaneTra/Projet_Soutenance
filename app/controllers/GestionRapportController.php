<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RapportEtudiant.php';
require_once __DIR__ . '/../models/Etudiant.php';

class GestionRapportController {

    private $baseViewPath;
    private $rapportModel;

    private $etudiant;

    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/gestion_rapports/';
        $this->rapportModel = new RapportEtudiant(Database::getConnection());
        $this->etudiant = new Etudiant(Database::getConnection());


        // Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['id_utilisateur'])) {
            header('Location: page_connexion.php');
            exit;
        }

        // Les variables sont déjà définies par votre AuthController
        // Pas besoin de les redéfinir, juste s'assurer qu'elles existent
        $this->verifierVariablesSession();
    }

    private function verifierVariablesSession()
    {

        $GLOBALS['candidatures_etudiant'] = $this->etudiant->getCandidatures($_SESSION['num_etu']);
        // Vérifier que les variables nécessaires sont présentes
        if (!isset($_SESSION['type_utilisateur'])) {
            throw new Exception("Variables de session manquantes. Veuillez vous reconnecter.");
        }

        // Pour les étudiants, s'assurer que num_etu est défini
        if ($_SESSION['type_utilisateur'] === 'Etudiant' && !isset($_SESSION['num_etu'])) {
            throw new Exception("Numéro étudiant manquant. Veuillez vous reconnecter.");
        }
    }

    private function isEtudiant()
    {
        return $_SESSION['type_utilisateur'] === 'Etudiant';
    }

    private function isAdmin()
    {
        return in_array($_SESSION['type_utilisateur'], [
            'Personnel administratif',
            'Enseignant simple',
            'Enseignant administratif'
        ]);
    }

    // Afficher le dashboard des rapports
    public function index()
    {
        try {
            global $statistiquesRapports, $rapportsRecents;

            if ($this->isEtudiant()) {
                $statistiquesRapports = $this->rapportModel->getStatsEtudiant($_SESSION['num_etu']);
                $rapportsRecents = $this->rapportModel->getRapportsByEtudiant($_SESSION['num_etu']);
                $rapportsRecents = array_slice($rapportsRecents, 0, 5); // Limiter à 5 pour le dashboard
            } else {
                $rapportsRecents = $this->rapportModel->getRecentRapports(5);
                $statistiquesRapports = $this->calculerStatistiquesGlobales();
            }

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement du dashboard : " . $e->getMessage());
        }
    }

    //=============================CREER UN RAPPORT=============================
    public function creerRapport()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->traiterCreationRapport();
        } else {
            global $rapport, $erreurs, $isEditMode, $contenuRapport;

            $edit_id = $_GET['edit'] ?? null;
            $rapport = null;
            $isEditMode = false;
            $contenuRapport = '';

            if ($edit_id) {
                // Temporairement, permettre à tous les utilisateurs de modifier les rapports
                $rapport = $this->rapportModel->getRapportById($edit_id);
                $isEditMode = true;

                if (!$rapport) {
                    $this->afficherErreur("Rapport non trouvé.");
                    return;
                }

                // Charger le contenu du rapport
                $fichierContenu = __DIR__ . "/../../ressources/uploads/rapports/rapport_{$edit_id}.html";
                if (file_exists($fichierContenu)) {
                    $contenuRapport = file_get_contents($fichierContenu);
                }

                // Convertir l'objet en tableau pour la vue
                $rapport = (array) $rapport;
            }

            $erreurs = $_SESSION['erreurs_form'] ?? [];
            unset($_SESSION['erreurs_form']);

            // Les données sont maintenant disponibles globalement pour la vue
        }
    }

    private function traiterCreationRapport()
    {
        try {
            $action = $_POST['action'] ?? '';

            if ($action === 'save_rapport') {
                $this->sauvegarderRapport();
            } elseif ($action === 'export_rapport') {
                $this->exporterRapport();
            } else {
                throw new Exception("Action non reconnue.");
            }

        } catch (Exception $e) {
            error_log("Exception dans traiterCreationRapport: " . $e->getMessage());

            // Toujours renvoyer du JSON pour les requêtes AJAX
            $this->sendJsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function sauvegarderRapport()
    {
        if (!$this->isEtudiant()) {
            throw new Exception('Seuls les étudiants peuvent créer des rapports.');
        }

        // Récupérer les données du formulaire
        $donneesRapport = [
            'nom_rapport' => trim($_POST['nom_rapport'] ?? ''),
            'theme_rapport' => trim($_POST['theme_rapport'] ?? ''),
            'contenu_rapport' => $_POST['contenu_rapport'] ?? '',
            'edit_id' => $_POST['edit_id'] ?? null
        ];

        // Validation des données
        $erreurs = $this->validerDonneesRapport($donneesRapport);

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $this->sendJsonResponse(['success' => false, 'message' => 'Erreurs de validation', 'errors' => $erreurs]);
            return;
        }

        // Vérifier si le nom du rapport existe déjà pour cet étudiant
        if ($this->rapportModel->isRapportNomExist($donneesRapport['nom_rapport'], $_SESSION['num_etu'], $donneesRapport['edit_id'])) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Vous avez déjà un rapport avec ce nom.']);
            return;
        }

        // Debug : afficher les données préparées
        error_log("Données pour sauvegarde: " . print_r($donneesRapport, true));
        error_log("Num étudiant: " . $_SESSION['num_etu']);

        if ($donneesRapport['edit_id']) {
            // Mode modification
            $result = $this->rapportModel->updateRapport(
                $donneesRapport['edit_id'],
                $_SESSION['num_etu'],
                $donneesRapport['nom_rapport'],
                $donneesRapport['theme_rapport']
            );
            $rapport_id = $donneesRapport['edit_id'];
            $message = 'Rapport modifié avec succès!';
        } else {
            // Mode création
            $rapport_id = $this->rapportModel->ajouterRapport(
                $_SESSION['num_etu'],
                $donneesRapport['nom_rapport'],
                $donneesRapport['theme_rapport']
            );
            $result = $rapport_id !== false;
            $message = 'Rapport enregistré avec succès!';
        }

        if ($result) {
            $this->sauvegarderContenuRapport($rapport_id, $donneesRapport['contenu_rapport']);
            $this->afficherMessage($message, 'success');
            $this->sendJsonResponse([
                'success' => true,
                'message' => $message,
                'rapport_id' => $rapport_id
            ]);
        } else {
            $messageErreur = 'Erreur lors de l\'enregistrement du rapport.';
            $debug = [
                'donneesRapport' => $donneesRapport,
                'num_etu' => $_SESSION['num_etu'],
                'result' => $result
            ];

            // Log fichier ou error_log pour voir côté serveur
            error_log("Erreur sauvegarde rapport: " . print_r($debug, true));

            // Affichage JSON clair dans Network > Response
            $this->sendJsonResponse([
                'success' => false,
                'message' => $messageErreur,
                'debug' => $debug // ⚠️ à retirer en prod
            ]);
        }
    }

    private function validerDonneesRapport($donnees)
    {
        $erreurs = [];

        if (empty($donnees['nom_rapport']) || strlen($donnees['nom_rapport']) < 5) {
            $erreurs['nom_rapport'] = 'Le nom du rapport doit contenir au moins 5 caractères.';
        }

        if (empty($donnees['theme_rapport']) || strlen($donnees['theme_rapport']) < 10) {
            $erreurs['theme_rapport'] = 'Le thème du rapport doit contenir au moins 10 caractères.';
        }

        if (empty($donnees['contenu_rapport']) || strlen(strip_tags($donnees['contenu_rapport'])) < 50) {
            $erreurs['contenu_rapport'] = 'Le contenu du rapport doit contenir au moins 50 caractères.';
        }

        return $erreurs;
    }

    private function sauvegarderContenuRapport($rapport_id, $contenu)
    {
        $dossierRapports = __DIR__ . '/../../ressources/uploads/rapports/';

        if (!is_dir($dossierRapports)) {
            if (!mkdir($dossierRapports, 0755, true)) {
                throw new Exception('Impossible de créer le dossier de stockage des rapports.');
            }
        }

        if (!is_writable($dossierRapports)) {
            throw new Exception('Le dossier de stockage des rapports n\'est pas accessible en écriture.');
        }

        $nomFichier = 'rapport_' . $rapport_id . '.html';
        $cheminComplet = $dossierRapports . $nomFichier;

        if (!file_put_contents($cheminComplet, $contenu)) {
            throw new Exception('Erreur lors de la sauvegarde du contenu du rapport.');
        }

        // Mettre à jour le chemin du fichier et sa taille dans la base
        $tailleFichier = filesize($cheminComplet);  // Correction ici
        $this->rapportModel->updateCheminFichier($rapport_id, $nomFichier, $tailleFichier);
    }

    private function exporterRapport()
    {
        $contenu_rapport = $_POST['contenu_rapport'] ?? '';
        $nom_rapport = $_POST['nom_rapport'] ?? 'rapport';

        if (empty($contenu_rapport)) {
            throw new Exception('Le contenu du rapport est vide.');
        }

        $htmlContent = "<!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>" . htmlspecialchars($nom_rapport) . "</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
                h1, h2, h3 { color: #333; margin-top: 20px; }
                p { margin-bottom: 15px; text-align: justify; }
                ul, ol { margin-bottom: 15px; padding-left: 30px; }
                .header { text-align: center; margin-bottom: 30px; }
                .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>" . htmlspecialchars($nom_rapport) . "</h1>
                <p>Généré le " . date('d/m/Y à H:i') . "</p>
                <p>Par : " . htmlspecialchars($_SESSION['nom_utilisateur']) . "</p>
            </div>
            {$contenu_rapport}
            <div class='footer'>
                <p>Document généré par le système de gestion des rapports</p>
            </div>
        </body>
        </html>";

        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . htmlspecialchars($nom_rapport) . '.html"');
        header('Content-Length: ' . strlen($htmlContent));
        echo $htmlContent;
        exit;
    }

    //=============================SUIVI RAPPORTS=============================
    public function suiviRapport()
    {
        try {
            global $rapports, $statistiques, $totalPages, $page, $totalRapports, $filtresActuels;

            $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Filtres
            $filtres = [];
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $filtres['recherche'] = $_GET['search'];
            }

            // Récupérer les rapports selon le type d'utilisateur
            if ($this->isEtudiant()) {
                $tousRapports = $this->rapportModel->getRapportsByEtudiant($_SESSION['num_etu']);

                if (isset($filtres['recherche'])) {
                    $tousRapports = array_filter($tousRapports, function($rapport) use ($filtres) {
                        $termeRecherche = strtolower($filtres['recherche']);
                        return (strpos(strtolower($rapport->nom_rapport), $termeRecherche) !== false ||
                            strpos(strtolower($rapport->theme_rapport), $termeRecherche) !== false);
                    });
                }

                $totalRapports = count($tousRapports);
                $rapports = array_map(function($rapport) {
                    return (array) $rapport;
                }, array_slice($tousRapports, $offset, $limit));

            } else {
                if (isset($filtres['recherche'])) {
                    $tousRapports = $this->rapportModel->searchRapports($filtres['recherche']);
                    $rapports = array_map(function($rapport) {
                        return (array) $rapport;
                    }, array_slice($tousRapports, $offset, $limit));
                    $totalRapports = count($tousRapports);
                } else {
                    $rapports = array_map(function($rapport) {
                        return (array) $rapport;
                    }, $this->rapportModel->getAllRapports());
                    $totalRapports = count($rapports);
                    $rapports = array_slice($rapports, $offset, $limit);
                }
            }

            $totalPages = ceil($totalRapports / $limit);
            $statistiques = $this->calculerStatistiques();
            $filtresActuels = $_GET;

            // Les données sont maintenant disponibles globalement pour la vue

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement du suivi : " . $e->getMessage());
        }
    }

    private function calculerStatistiques()
    {
        if ($this->isEtudiant()) {
            $stats = $this->rapportModel->getStatsEtudiant($_SESSION['num_etu']);
            return [
                'total' => $stats->total_rapports ?? 0,
                'aujourd_hui' => $stats->rapports_aujourd_hui ?? 0,
                'semaine' => $stats->rapports_semaine ?? 0,
                'mois' => $stats->rapports_mois ?? 0
            ];
        } else {
            return $this->calculerStatistiquesGlobales();
        }
    }

    private function calculerStatistiquesGlobales()
    {
        $rapports = $this->rapportModel->getAllRapports();

        $stats = [
            'total' => count($rapports),
            'aujourd_hui' => 0,
            'semaine' => 0,
            'mois' => 0
        ];

        $maintenant = time();
        $debutJour = strtotime('today');
        $debutSemaine = strtotime('monday this week');
        $debutMois = strtotime('first day of this month');

        foreach ($rapports as $rapport) {
            $dateRapport = strtotime($rapport->date_rapport);

            if ($dateRapport >= $debutJour) {
                $stats['aujourd_hui']++;
            }
            if ($dateRapport >= $debutSemaine) {
                $stats['semaine']++;
            }
            if ($dateRapport >= $debutMois) {
                $stats['mois']++;
            }
        }

        return $stats;
    }

    //=============================COMPTE RENDU RAPPORTS=============================
    public function compteRenduRapport()
    {
        try {
            // Si un ID est spécifié, afficher le détail
            if (isset($_GET['id'])) {
                $this->afficherDetailRapport($_GET['id']);
                return;
            }

            global $rapports, $statistiquesCompteRendu;

            if ($this->isEtudiant()) {
                $rapports = array_map(function($rapport) {
                    return (array) $rapport;
                }, $this->rapportModel->getRapportsByEtudiant($_SESSION['num_etu']));
            } else {
                $rapports = array_map(function($rapport) {
                    return (array) $rapport;
                }, $this->rapportModel->getAllRapports());
            }

            $statistiquesCompteRendu = $this->calculerStatistiques();

            // Les données sont maintenant disponibles globalement pour la vue

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement du compte rendu : " . $e->getMessage());
        }
    }

    private function afficherDetailRapport($id)
    {
        global $rapport, $contenuRapport;

        // Debug
        error_log("AfficherDetailRapport - ID: $id");
        error_log("Type utilisateur: " . ($_SESSION['type_utilisateur'] ?? 'non défini'));
        error_log("Num étudiant: " . ($_SESSION['num_etu'] ?? 'non défini'));

        // Temporairement, permettre à tous les utilisateurs de voir les rapports
        $rapport = $this->rapportModel->getRapportById($id);
        error_log("Rapport trouvé: " . ($rapport ? 'oui' : 'non'));

        if (!$rapport) {
            $this->afficherErreur("Rapport non trouvé.");
            return;
        }

        // Lire le contenu du rapport - Correction du chemin
        $fichierContenu = __DIR__ . "/../../ressources/uploads/rapports/rapport_{$id}.html";
        error_log("Chemin du fichier: $fichierContenu");
        error_log("Fichier existe: " . (file_exists($fichierContenu) ? 'oui' : 'non'));
        
        $contenuRapport = '';
        if (file_exists($fichierContenu)) {
            $contenuRapport = file_get_contents($fichierContenu);
            error_log("Taille du contenu: " . strlen($contenuRapport));
        }

        // Convertir l'objet en tableau pour la vue
        $rapport = (array) $rapport;

        // Forcer l'inclusion de la vue de détail
        $contentFile = $this->baseViewPath . 'detail_rapport.php';
        if (file_exists($contentFile)) {
            include $contentFile;
        } else {
            $this->afficherErreur("Vue de détail non trouvée.");
        }
        exit; // Empêcher l'affichage de la vue normale
    }

    //=============================ACTIONS AJAX=============================
    public function deleteRapportAjax()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->sendJsonResponse(['success' => false, 'message' => 'Méthode non autorisée']);
            return;
        }

        if (!$this->isEtudiant()) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Accès non autorisé']);
            return;
        }

        try {
            $rapport_id = $_POST['rapport_id'] ?? 0;

            if (!$rapport_id) {
                $this->sendJsonResponse(['success' => false, 'message' => 'ID du rapport manquant']);
                return;
            }

            $result = $this->rapportModel->deleteRapport($rapport_id, $_SESSION['num_etu']);

            if ($result) {
                // Supprimer le fichier de contenu
                $filename = __DIR__ . "/../../ressources/uploads/rapports/rapport_{$rapport_id}.html";
                if (file_exists($filename)) {
                    unlink($filename);
                }

                $this->sendJsonResponse(['success' => true, 'message' => 'Rapport supprimé avec succès']);
            } else {
                $this->sendJsonResponse(['success' => false, 'message' => 'Rapport non trouvé ou non autorisé']);
            }
        } catch (Exception $e) {
            error_log("Erreur suppression rapport: " . $e->getMessage());
            $this->sendJsonResponse(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    public function getRapportAjax()
    {
        if (!$this->isEtudiant()) {
            $this->sendJsonResponse(['success' => false, 'message' => 'Accès non autorisé']);
            return;
        }

        try {
            $rapport_id = $_GET['id'] ?? 0;

            if (!$rapport_id) {
                $this->sendJsonResponse(['success' => false, 'message' => 'ID du rapport manquant']);
                return;
            }

            $rapport = $this->rapportModel->getRapportByIdAndEtudiant($rapport_id, $_SESSION['num_etu']);

            if (!$rapport) {
                $this->sendJsonResponse(['success' => false, 'message' => 'Rapport non trouvé']);
                return;
            }

            // Lire le contenu du rapport
            $filename = __DIR__ . "/../../ressources/uploads/rapports/rapport_{$rapport_id}.html";
            $contenu = '';
            if (file_exists($filename)) {
                $contenu = file_get_contents($filename);
            }

            $rapport_array = (array) $rapport;
            $rapport_array['contenu'] = $contenu;
            $this->sendJsonResponse(['success' => true, 'data' => $rapport_array]);
        } catch (Exception $e) {
            error_log("Erreur récupération rapport: " . $e->getMessage());
            $this->sendJsonResponse(['success' => false, 'message' => 'Erreur lors de la récupération']);
        }
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
        // Utiliser les groupes utilisateur de votre système
        $groupesAdmin = [5, 6, 7, 8]; // Admins, secrétaires, etc.
        return in_array($_SESSION['id_GU'] ?? 0, $groupesAdmin);
    }

    private function sendJsonResponse($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function exporterRapports()
    {
        if (!$this->verifierDroitsAdmin()) {
            $this->afficherErreur("Accès non autorisé.");
            return;
        }

        try {
            $rapports = $this->rapportModel->getAllRapports();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=rapports_' . date('Y-m-d') . '.csv');

            $output = fopen('php://output', 'w');

            // En-têtes CSV
            fputcsv($output, [
                'ID', 'Nom du rapport', 'Thème', 'Date création',
                'Étudiant', 'Email étudiant'
            ]);

            // Données
            foreach ($rapports as $rapport) {
                fputcsv($output, [
                    $rapport->id_rapport,
                    $rapport->nom_rapport,
                    $rapport->theme_rapport,
                    $rapport->date_rapport,
                    $rapport->nom_etu . ' ' . $rapport->prenom_etu,
                    $rapport->email_etu
                ]);
            }

            fclose($output);
        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors de l'export : " . $e->getMessage());
        }
    }

    private function verifierDroitsAcces($rapport)
    {
        if ($this->isEtudiant()) {
            // Un étudiant ne peut voir que ses propres rapports
            return $rapport['num_etu'] == $_SESSION['num_etu'];
        } else {
            // Le personnel administratif peut voir tous les rapports
            return true;
        }
    }


}
?>