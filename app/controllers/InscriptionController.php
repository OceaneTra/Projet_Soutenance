<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Scolarite.php';
require_once __DIR__ . '/../models/AnneeAcademique.php';


class InscriptionController {
    private $db;
    private $scolarite;
    private $anneeAcademique;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->scolarite = new Scolarite($this->db);
        $this->anneeAcademique = new AnneeAcademique($this->db);
    }

    public function index() {
        // Récupérer les étudiants non inscrits
        $GLOBALS['etudiantsNonInscrits'] = $this->scolarite->getEtudiantsNonInscrits();
        
        // Récupérer les niveaux d'études
        $GLOBALS['niveaux'] = $this->scolarite->getNiveauxEtudes();
        
        // Récupérer les étudiants déjà inscrits
        $GLOBALS['etudiantsInscrits'] = $this->scolarite->getEtudiantsInscrits();
        
        // Récupérer les années académiques
        $GLOBALS['listeAnnees'] = $this->anneeAcademique->getAllAnneeAcademiques();

        // Si un numéro d'étudiant est fourni, récupérer ses informations
        if (isset($_GET['num_etu'])) {
            $GLOBALS['etudiantInfo'] = $this->scolarite->getInfoEtudiant($_GET['num_etu']);
        }

        // Si on est en mode modification, récupérer les informations de l'inscription
        if (isset($_GET['modalAction']) && $_GET['modalAction'] === 'modifier' && isset($_GET['id'])) {
            $GLOBALS['inscriptionAModifier'] = $this->scolarite->getInscriptionById($_GET['id']);
            if ($GLOBALS['inscriptionAModifier']) {
                $GLOBALS['etudiantInfo'] = $this->scolarite->getInfoEtudiant($GLOBALS['inscriptionAModifier']['id_etudiant']);
            }
        }

        // Traiter la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'inscrire':
                        $this->traiterInscription();
                        break;
                    case 'modifier':
                        $this->modifierInscription();
                        break;
                    case 'supprimer':
                        $this->supprimerInscription();
                        break;
                }
            }
        }

        // Gérer les requêtes AJAX
        if (isset($_GET['action']) && $_GET['action'] === 'get_etudiant_info') {
            $this->getEtudiantInfo();
        }
    }

    private function traiterInscription() {
        try {
            // Validation des données
            if (empty($_POST['etudiant']) || empty($_POST['niveau']) || empty($_POST['premier_versement']) || empty($_POST['annee_academique'])) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                return;
            }

            $id_etudiant = $_POST['etudiant'];
            $id_niveau = $_POST['niveau'];
            $id_annee_acad = $_POST['annee_academique'];
            $montant_premier_versement = floatval($_POST['premier_versement']);
            $nombre_tranches = isset($_POST['nombre_tranches']) ? intval($_POST['nombre_tranches']) : 1;
            $reste_a_payer = floatval(str_replace([' ', ' '], '', $_POST['reste_payer']));

            // Vérifier si l'étudiant est déjà inscrit pour cette année académique
            if ($this->scolarite->estEtudiantInscritPourAnnee($id_etudiant, $id_annee_acad)) {
                $_SESSION['error'] = "Cet étudiant est déjà inscrit pour cette année académique.";
                return;
            }

            // Créer l'inscription avec le premier versement
            $id_inscription = $this->scolarite->creerInscription($id_etudiant, $id_niveau, $id_annee_acad, $montant_premier_versement, $nombre_tranches,$reste_a_payer);

            if ($id_inscription) {
                // Si des tranches sont demandées, les créer
                if ($nombre_tranches > 1) {
                    $montant_total = $this->scolarite->getMontantScolarite($id_niveau);
                    $reste_a_payer = $montant_total - $montant_premier_versement;
                    $montant_tranche = $reste_a_payer / ($nombre_tranches - 1);

                    // Calculer la date de la première échéance (3 mois après l'inscription)
                    $date_echeance = date('Y-m-d', strtotime('+3 months'));

                    // Créer les échéances
                    for ($i = 1; $i < $nombre_tranches; $i++) {
                        $this->scolarite->creerEcheance($id_inscription, $montant_tranche, $date_echeance);
                        $date_echeance = date('Y-m-d', strtotime($date_echeance . ' +3 months'));
                    }
                }

                $_SESSION['success'] = "Inscription créée avec succès.";
                header('Location: ?page=gestion_etudiants&action=inscrire_des_etudiants');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la création de l'inscription.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
        }
    }

    private function modifierInscription() {
        try {
            if (empty($_POST['id_inscription']) || empty($_POST['niveau']) || empty($_POST['premier_versement'])) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                return;
            }

            $id_inscription = $_POST['id_inscription'];
            $id_annee_acad = $_POST['annee_academique'];
            $id_niveau = $_POST['niveau'];
            $montant_premier_versement = floatval($_POST['premier_versement']);
            $nombre_tranches = isset($_POST['nombre_tranches']) ? intval($_POST['nombre_tranches']) : 1;

            // Mettre à jour l'inscription
            if ($this->scolarite->modifierInscription($id_inscription, $id_niveau,$id_annee_acad,$montant_premier_versement,$nombre_tranches)) {
                // Supprimer les anciennes échéances
                $this->scolarite->supprimerEcheances($id_inscription);

                // Créer les nouvelles échéances si nécessaire
                if ($nombre_tranches > 1) {
                    $montant_total = $this->scolarite->getMontantScolarite($id_niveau);
                    $reste_a_payer = $montant_total - $montant_premier_versement;
                    $montant_tranche = $reste_a_payer / ($nombre_tranches - 1);

                    $date_echeance = date('Y-m-d', strtotime('+3 months'));
                    for ($i = 1; $i < $nombre_tranches; $i++) {
                        $this->scolarite->creerEcheance($id_inscription, $montant_tranche, $date_echeance);
                        $date_echeance = date('Y-m-d', strtotime($date_echeance . ' +3 months'));
                    }
                }

                $_SESSION['success'] = "Inscription modifiée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la modification de l'inscription.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
        }
    }

    private function supprimerInscription() {
        try {
            if (empty($_POST['id_inscription'])) {
                $_SESSION['error'] = "ID d'inscription manquant.";
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => "ID d'inscription manquant."]);
                    exit;
                }
                return;
            }

            $id_inscription = $_POST['id_inscription'];

            // Supprimer d'abord les échéances associées
            $this->scolarite->supprimerEcheances($id_inscription);

            // Puis supprimer l'inscription
            if ($this->scolarite->supprimerInscription($id_inscription)) {
                $_SESSION['success'] = "Inscription supprimée avec succès.";
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => true]);
                    exit;
                }
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'inscription.";
                if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                    echo json_encode(['success' => false, 'message' => "Erreur lors de la suppression de l'inscription."]);
                    exit;
                }
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        }
    }

    private function getEtudiantInfo() {
        if (isset($_GET['num_etu'])) {
            $etudiant = $this->scolarite->getInfoEtudiant($_GET['num_etu']);
            if ($etudiant) {
                echo json_encode([
                    'success' => true,
                    'etudiant' => $etudiant
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Étudiant non trouvé'
                ]);
            }
            exit;
        }
    }
} 