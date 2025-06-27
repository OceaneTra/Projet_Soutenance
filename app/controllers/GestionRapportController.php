<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/RapportEtudiant.php';

require_once __DIR__ . '/../models/Etudiant.php';

require_once __DIR__ . '/../models/RapportEtudiants.php';
require_once __DIR__ . '/../models/Approuver.php';


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
            global $statistiquesRapports, $rapportsRecents, $infosDepot;

            if ($this->isEtudiant()) {
                $statistiquesRapports = $this->rapportModel->getStatsEtudiant($_SESSION['num_etu']);
                $rapportsRecents = $this->rapportModel->getRapportsByEtudiant($_SESSION['num_etu']);
                $rapportsRecents = array_slice($rapportsRecents, 0, 5); // Limiter à 5 pour le dashboard
                
                // Récupérer les informations de dépôt pour chaque rapport
                $infosDepot = $this->getInfosDepotRapports($_SESSION['num_etu']);
            } else {
                $rapportsRecents = $this->rapportModel->getRecentRapports(5);
                $statistiquesRapports = $this->calculerStatistiquesGlobales();
            }

        } catch (Exception $e) {
            $this->afficherErreur("Erreur lors du chargement du dashboard : " . $e->getMessage());
        }
    }

    /**
     * Récupère les informations de dépôt pour tous les rapports d'un étudiant
     */
    private function getInfosDepotRapports($num_etu)
    {
        $infos = [];
        
        // Récupérer tous les rapports de l'étudiant
        $rapports = $this->rapportModel->getRapportsByEtudiant($num_etu);
        
        foreach ($rapports as $rapport) {
            $rapportId = $rapport->id_rapport;
            
            // Vérifier si ce rapport est déjà déposé
            $stmt = $this->rapportModel->pdo->prepare("SELECT COUNT(*) FROM deposer WHERE num_etu = ? AND id_rapport = ?");
            $stmt->execute([$num_etu, $rapportId]);
            $dejaDepose = $stmt->fetchColumn() > 0;
            
            $peutDeposer = true;
            $messageDepot = '';
            
            if ($dejaDepose) {
                $peutDeposer = false;
                $messageDepot = 'Déjà déposé';
            } else {
                // Vérifier si l'étudiant a un autre rapport en cours d'évaluation
                $stmt = $this->rapportModel->pdo->prepare("
                    SELECT d.id_rapport, d.date_depot 
                    FROM deposer d 
                    WHERE d.num_etu = ? 
                    ORDER BY d.date_depot DESC 
                    LIMIT 1
                ");
                $stmt->execute([$num_etu]);
                $dernierDepot = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($dernierDepot && $dernierDepot['id_rapport'] != $rapportId) {
                    // Vérifier le statut d'approbation du dernier rapport déposé
                    $stmt = $this->rapportModel->pdo->prepare("
                        SELECT a.*, n.lib_approb 
                        FROM approuver a
                        JOIN niveau_approbation n ON a.id_approb = n.id_approb
                        WHERE a.id_rapport = ?
                        ORDER BY a.date_approv DESC
                        LIMIT 1
                    ");
                    $stmt->execute([$dernierDepot['id_rapport']]);
                    $derniereApprobation = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if (!$derniereApprobation || strtolower($derniereApprobation['lib_approb']) !== 'rejeté') {
                        $peutDeposer = false;
                        $messageDepot = 'Vous avez déjà un rapport en cours d\'évaluation';
                    }
                }
            }
            
            $infos[$rapportId] = [
                'peutDeposer' => $peutDeposer,
                'messageDepot' => $messageDepot,
                'dejaDepose' => $dejaDepose
            ];
        }
        
        return $infos;
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

    public function traiterCreationRapport()
    {
        try {
            $action = $_POST['action'] ?? '';

            if ($action === 'save_rapport') {
                $this->sauvegarderRapport();
            } elseif ($action === 'deposer_rapport') {
                $id_rapport = $_POST['id_rapport'] ?? null;
                if (!$id_rapport && isset($_POST['edit_id'])) {
                    $id_rapport = $_POST['edit_id'];
                }
                if (!$id_rapport) {
                    // Si on vient de la création, il faut d'abord créer le rapport puis le déposer
                    $this->sendJsonResponse(['success' => false, 'message' => 'Aucun rapport à déposer.']);
                    return;
                }
                $result = $this->enregistrerDepotRapport($id_rapport);
                if ($result) {
                    header('Location: ?page=gestion_rapports&message=depot_ok');
                    exit;
                } else {
                    // Vérifier la raison de l'échec
                    if ($this->aUnRapportEnCours($_SESSION['num_etu'])) {
                        header('Location: ?page=gestion_rapports&message=depot_en_cours');
                        exit;
                    } else {
                        header('Location: ?page=gestion_rapports&message=depot_fail');
                        exit;
                    }
                }
            } elseif ($action === 'export_pdf') {
                $this->exporterRapport();
            } else {
                throw new Exception("Action non reconnue.");
            }

        } catch (Exception $e) {
            error_log("Exception dans traiterCreationRapport: " . $e->getMessage());
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
        try {
            // Vérifier que DOMPDF est disponible
            if (!class_exists('\Dompdf\Dompdf')) {
                require_once __DIR__ . '/../../vendor/autoload.php';
            }
            
            if (!class_exists('\Dompdf\Dompdf')) {
                throw new Exception('DOMPDF n\'est pas installé ou accessible.');
            }
            
            $contenu_rapport = $_POST['contenu_rapport'] ?? '';
            $nom_rapport = $_POST['nom_rapport'] ?? 'rapport';

            if (empty($contenu_rapport)) {
                throw new Exception('Le contenu du rapport est vide.');
            }

            // Style CSS amélioré pour préserver exactement la mise en page TinyMCE
            $css = "
                <style>
                    /* Styles de base */
                    body { 
                        font-family: Arial, sans-serif; 
                        margin: 2cm; 
                        line-height: 1.6; 
                        font-size: 12pt;
                        color: #333;
                        text-align: left;
                    }
                    
                    /* Préserver tous les styles inline */
                    * {
                        box-sizing: border-box;
                    }
                    
                    /* Préserver les tailles de police exactes */
                    h1, h2, h3, h4, h5, h6 {
                        margin: 0;
                        padding: 0;
                        text-align: center;
                    }
                    
                    /* Préserver les dispositions flexbox */
                    div[style*='display: flex'] {
                        display: flex !important;
                    }
                    
                    div[style*='justify-content'] {
                        justify-content: inherit !important;
                    }
                    
                    div[style*='align-items'] {
                        align-items: inherit !important;
                    }
                    
                    div[style*='flex-direction'] {
                        flex-direction: inherit !important;
                    }
                    
                    /* Préserver les marges et paddings */
                    div[style*='margin'] {
                        margin: inherit !important;
                    }
                    
                    div[style*='padding'] {
                        padding: inherit !important;
                    }
                    
                    /* Préserver les tailles de police */
                    span[style*='font-size'], p[style*='font-size'], div[style*='font-size'] {
                        font-size: inherit !important;
                    }
                    
                    /* Préserver les couleurs */
                    span[style*='color'], p[style*='color'], div[style*='color'] {
                        color: inherit !important;
                    }
                    
                    /* Préserver les alignements de texte */
                    div[style*='text-align'] {
                        text-align: inherit !important;
                    }
                    
                    /* Alignement par défaut pour les paragraphes - JUSTIFIÉ */
                    p {
                        text-align: justify !important;
                        margin: 0 0 10px 0;
                    }
                    
                    /* Préserver l'alignement centré pour les éléments spécifiques */
                    div[style*='text-align: center'] {
                        text-align: center !important;
                    }
                    
                    /* Préserver les bordures et backgrounds */
                    div[style*='border'] {
                        border: inherit !important;
                    }
                    
                    div[style*='background'] {
                        background: inherit !important;
                    }
                    
                    /* Préserver les largeurs et hauteurs */
                    div[style*='width'] {
                        width: inherit !important;
                    }
                    
                    div[style*='height'] {
                        height: inherit !important;
                    }
                    
                    /* Préserver les positions */
                    div[style*='position'] {
                        position: inherit !important;
                    }
                    
                    /* Assurer que les images ne dépassent pas */
                    img {
                        max-width: 100%;
                        height: auto;
                    }
                    
                    /* Assurer que les tableaux s'affichent correctement */
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }
                    
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    
                    /* Préserver les listes */
                    ul, ol {
                        margin: 0;
                        padding-left: 20px;
                        text-align: left;
                    }
                    
                    li {
                        margin-bottom: 5px;
                        text-align: left;
                    }
                    
                    /* Préserver les espaces entre les éléments */
                    div {
                        margin-bottom: 0;
                    }
                    
                    /* Assurer que les éléments flex s'affichent correctement */
                    .flex-container {
                        display: flex !important;
                    }
                    
                    /* Préserver les styles spécifiques du template */
                    div[style*='display: flex'][style*='justify-content: space-between'] {
                        display: flex !important;
                        justify-content: space-between !important;
                    }
                    
                    div[style*='margin-bottom'] {
                        margin-bottom: inherit !important;
                    }
                    
                    /* Règles spécifiques pour le contenu du rapport */
                    /* S'assurer que les sections principales du corps sont justifiées */
                    div[style*='margin-bottom: 40px'] p {
                        text-align: justify !important;
                    }
                    
                    /* S'assurer que les paragraphes dans les sections sont justifiés */
                    div[style*='margin-bottom: 40px'] {
                        text-align: justify !important;
                    }
                    
                    /* Préserver l'alignement des titres de sections à gauche */
                    h1[style*='border-bottom'] {
                        text-align: left !important;
                    }
                    
                    /* S'assurer que tous les paragraphes de contenu sont justifiés */
                    div:not([style*='text-align: center']) p {
                        text-align: justify !important;
                    }
                    
                    /* Exception pour les paragraphes centrés */
                    div[style*='text-align: center'] p {
                        text-align: center !important;
                    }
                    
                    /* Centrer spécifiquement le contenu de la div theme_rapport */
                    #theme_rapport {
                        text-align: center !important;
                        margin-botton:20px;
                    }
                    
                    #theme_rapport p {
                        text-align: center !important;
                    }
                    
                    #theme_rapport h2 {
                        text-align: center !important;
                    }
                    
                    /* S'assurer que header_rapport utilise flexbox */
                    #header_rapport {
                        display: flex !important;
                        justify-content: space-between !important;
                        align-items: flex-start !important;
                        width: 100% !important;
                        margin : 0;
                        text-align: left;
                    }
                    
                    /* S'assurer que les éléments enfants de header_rapport s'affichent correctement */
                    #header_rapport1, #header_rapport2 {
                        flex: 1 !important;
                        margin: 0 !important;
                    }
                    
                    #header_rapport1 {
                        text-align: center !important;
                    }
                    
                    #header_rapport2 {
                        text-align: center !important;
                    }
                </style>
            ";

            // Utiliser directement le contenu HTML de l'éditeur
            $htmlContent = "<!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <title>" . htmlspecialchars($nom_rapport) . "</title>
                {$css}
            </head>
            <body>
                {$contenu_rapport}
            </body>
            </html>";

            // Debug: logger le contenu HTML
            error_log("HTML Content length: " . strlen($htmlContent));

            // Configuration DOMPDF optimisée pour préserver les styles
            $options = new \Dompdf\Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', false);
            $options->set('isRemoteEnabled', false);
            $options->set('defaultFont', 'Arial');
            $options->set('defaultPaperSize', 'A4');
            $options->set('defaultPaperOrientation', 'portrait');
            $options->set('isFontSubsettingEnabled', true);
            $options->set('isCssFloatEnabled', true);
            $options->set('isJavascriptEnabled', false);

            $dompdf = new \Dompdf\Dompdf($options);
            
            // Debug: vérifier que DOMPDF est bien instancié
            if (!$dompdf) {
                throw new Exception('Impossible d\'instancier DOMPDF.');
            }
            
            $dompdf->loadHtml($htmlContent);
            $dompdf->setPaper('A4', 'portrait');
            
            // Debug: logger avant le rendu
            error_log("Starting PDF rendering...");
            
            $dompdf->render();
            
            // Debug: logger après le rendu
            error_log("PDF rendering completed.");

            // Nettoyer le nom du fichier
            $pdfName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nom_rapport) . '.pdf';
            
            // Définir les headers pour le téléchargement
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $pdfName . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($dompdf->output()));
            
            echo $dompdf->output();
            exit;

        } catch (Exception $e) {
            error_log("Erreur lors de l'export PDF: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            
            // Retourner une réponse JSON en cas d'erreur
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Erreur lors de la génération du PDF: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    //=============================SUIVI RAPPORTS=============================
    public function suiviRapport($num_etu)
    {
        global $rapports;
        // Récupérer les rapports de l'étudiant
        $rapports = RapportEtudiants::getByEtudiant($num_etu);

        // Pour chaque rapport, récupérer l'historique des décisions
        foreach ($rapports as &$rapport) {
            $rapport['decisions'] = Approuver::getByRapport($rapport['id_rapport']);
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

    //=============================COMMENTAIRE RAPPORT=============================
    public function commentaireRapport()
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


    public function enregistrerDepotRapport($id_rapport)
    {
        $num_etu = $_SESSION['num_etu'];
        $date_depot = date('Y-m-d H:i:s');

        // Vérifier si l'étudiant a déjà un rapport en cours d'évaluation
        if ($this->aUnRapportEnCours($num_etu)) {
            return false;
        }

        // Vérifier si le dépôt existe déjà (éviter les doublons)
        $stmt = $this->rapportModel->pdo->prepare("SELECT COUNT(*) FROM deposer WHERE num_etu = ? AND id_rapport = ?");
        $stmt->execute([$num_etu, $id_rapport]);
        if ($stmt->fetchColumn() > 0) {
            // Déjà déposé
            return false;
        }

        // Insérer le dépôt
        $stmt = $this->rapportModel->pdo->prepare("INSERT INTO deposer (num_etu, id_rapport, date_depot) VALUES (?, ?, ?)");
        return $stmt->execute([$num_etu, $id_rapport, $date_depot]);
    }

    /**
     * Vérifie si l'étudiant a un rapport en cours d'évaluation (non rejeté)
     */
    private function aUnRapportEnCours($num_etu)
    {
        // Récupérer le dernier rapport déposé par l'étudiant
        $stmt = $this->rapportModel->pdo->prepare("
            SELECT d.id_rapport, d.date_depot 
            FROM deposer d 
            WHERE d.num_etu = ? 
            ORDER BY d.date_depot DESC 
            LIMIT 1
        ");
        $stmt->execute([$num_etu]);
        $dernierDepot = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dernierDepot) {
            // Aucun rapport déposé, peut déposer
            return false;
        }

        // Vérifier le statut d'approbation du dernier rapport déposé
        $stmt = $this->rapportModel->pdo->prepare("
            SELECT a.*, n.lib_approb 
            FROM approuver a
            JOIN niveau_approbation n ON a.id_approb = n.id_approb
            WHERE a.id_rapport = ?
            ORDER BY a.date_approv DESC
            LIMIT 1
        ");
        $stmt->execute([$dernierDepot['id_rapport']]);
        $derniereApprobation = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si pas d'approbation ou si le statut n'est pas "rejeté", l'étudiant ne peut pas déposer
        if (!$derniereApprobation || strtolower($derniereApprobation['lib_approb']) !== 'rejeté') {
            return true; // A un rapport en cours
        }

        return false; // Peut déposer un nouveau rapport
    }

    /**
     * Supprime un rapport (appelé via formulaire POST)
     */
    public function supprimer_rapport()
    {
        // Vérifier que c'est bien un POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return; // Ne rien faire si ce n'est pas un POST
        }

        try {
            // Vérifier que l'utilisateur est connecté
            if (!$this->isEtudiant()) {
                $this->afficherErreur('Accès non autorisé');
                return;
            }

            // Vérifier que l'ID du rapport est fourni
            if (!isset($_POST['rapport_id']) || empty($_POST['rapport_id'])) {
                $this->afficherErreur('ID du rapport manquant');
                return;
            }

            $rapportId = (int)$_POST['rapport_id'];
            $numEtu = $_SESSION['num_etu'];

            // Vérifier que le rapport appartient à l'étudiant
            $rapport = $this->rapportModel->getRapportById($rapportId);
            if (!$rapport || $rapport->num_etu != $numEtu) {
                $this->afficherErreur('Rapport non trouvé ou accès non autorisé');
                return;
            }

            // Vérifier que le rapport n'est pas déjà déposé
            $stmt = $this->rapportModel->pdo->prepare("SELECT COUNT(*) FROM deposer WHERE num_etu = ? AND id_rapport = ?");
            $stmt->execute([$numEtu, $rapportId]);
            if ($stmt->fetchColumn() > 0) {
                $this->afficherErreur('Impossible de supprimer un rapport déjà déposé');
                return;
            }

            // Supprimer le rapport
            $success = $this->rapportModel->deleteRapport($rapportId, $numEtu);

            if ($success) {
                // Rediriger avec un message de succès
                header('Location: ?page=gestion_rapports&message=suppression_ok');
                exit;
            } else {
                $this->afficherErreur('Erreur lors de la suppression du rapport');
            }

        } catch (Exception $e) {
            $this->afficherErreur('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }



  

}
?>