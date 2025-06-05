<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Scolarite.php';
require_once __DIR__ . '/../models/AnneeAcademique.php';

class GestionScolariteController {
    private $scolariteModel;
    private $anneeAcademique;
    

    public function __construct() {
        $this->scolariteModel = new Scolarite(Database::getConnection());
        $this->anneeAcademique = new AnneeAcademique(Database::getConnection());
    }

    public function index() {
       

        // Récupérer les étudiants non inscrits
        $GLOBALS['etudiantsNonInscrits'] = $this->scolariteModel->getEtudiantsNonInscrits();
        
        // Récupérer les niveaux d'études
        $GLOBALS['niveaux'] = $this->scolariteModel->getNiveauxEtudes();
        
        // Récupérer les étudiants déjà inscrits
        $GLOBALS['etudiantsInscrits'] = $this->scolariteModel->getEtudiantsInscrits();
        
        // Récupérer la liste complète des étudiants
        $GLOBALS['listeAllEtudiant'] = $this->scolariteModel->getAllEtudiants();
        
        // Récupérer les années académiques
        $GLOBALS['listeAnnees'] = $this->anneeAcademique->getAllAnneeAcademiques();



        // Si un numéro d'étudiant est fourni, récupérer ses informations
        if (isset($_GET['num_etu'])) {
            $GLOBALS['etudiantInfo'] = $this->scolariteModel->getInfoEtudiant($_GET['num_etu']);
        }


        // Traiter la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'enregistrer_versement':
                        $this->enregistrerVersement();
                        break;
                    case 'mettre_a_jour_versement':
                        $this->mettreAJourVersement();
                        break;
                    case 'supprimer_versements':
                        $this->supprimerVersement();
                        break;
                    case 'imprimer_recu':
                        $this->imprimerRecu();
                        break;
                }
            }
        }

        // Passer les messages à la vue
        $GLOBALS['listeVersement'] = $this->scolariteModel->getAllVersements();
    }

    public function enregistrerVersement() {
        // Valider les données du formulaire POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageErreur = '';
            $messageSuccess = '';
            
            $id_etudiant = $_POST['id_etudiant'] ?? null;
            $montant = $_POST['montant'] ?? null;
            $date_versement = $_POST['date_versement'] ?? null;
            $methode_paiement = $_POST['methode_paiement'] ?? null;

            // Validation des données
            if (!$id_etudiant || !$montant || !$date_versement || !$methode_paiement) {
                $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
                return;
            }

            // Récupérer l'id_inscription à partir de l'id_etudiant
            $inscription = $this->scolariteModel->getInscriptionByEtudiantId($id_etudiant);
            if (!$inscription) {
                $GLOBALS['messageErreur'] = "Aucune inscription trouvée pour cet étudiant.";
                return;
            }

            // Vérifier si le montant ne dépasse pas le reste à payer
            $montant_total = $inscription['montant_scolarite'];
            $montant_paye = $inscription['montant_inscription'];
            $reste_a_payer = $montant_total - $montant_paye;

            if ($montant > $reste_a_payer) {
                $GLOBALS['messageErreur'] = "Le montant du versement ne peut pas dépasser le reste à payer.";
                return;
            }

            // Enregistrer le versement
            if ($this->scolariteModel->enregistrerVersement($inscription['id_inscription'], $montant, $date_versement, $methode_paiement)) {
                $messageSuccess = "Versement enregistré avec succès.";
            } else {
                $messageErreur = "Erreur lors de l'enregistrement du versement.";
            }
        }

        $GLOBALS['messageSuccess'] = $messageSuccess;
        $GLOBALS['messageErreur'] = $messageErreur;
    }

    public function mettreAJourVersement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $messageErreur = '';
            $messageSuccess = '';
            
            $id_versement = $_POST['id_versement'] ?? null;
            $id_etudiant = $_POST['id_etudiant'] ?? null;
            $montant = $_POST['montant'] ?? null;
            $date_versement = $_POST['date_versement'] ?? null;
            $methode_paiement = $_POST['methode_paiement'] ?? null;

            // Validation des données
            if (!$id_versement || !$id_etudiant || !$montant || !$date_versement || !$methode_paiement) {
                $GLOBALS['messageErreur'] = "Tous les champs sont obligatoires.";
                return;
            }

            // Récupérer l'id_inscription à partir de l'id_etudiant
            $inscription = $this->scolariteModel->getInscriptionByEtudiantId($id_etudiant);
            if (!$inscription) {
                $GLOBALS['messageErreur'] = "Aucune inscription trouvée pour cet étudiant.";
                return;
            }

            // Récupérer le versement actuel
            $versement_actuel = $this->scolariteModel->getVersementById($id_versement);
            if (!$versement_actuel) {
                $GLOBALS['messageErreur'] = "Versement non trouvé.";
                return;
            }

            // Vérifier si le nouveau montant ne dépasse pas le reste à payer
            $montant_total = $inscription['montant_scolarite'];
            $montant_paye = $inscription['montant_inscription'] - $versement_actuel['montant'] + $montant;
            $reste_a_payer = $montant_total - $montant_paye;

            if ($montant > $reste_a_payer) {
                $GLOBALS['messageErreur'] = "Le montant du versement ne peut pas dépasser le reste à payer.";
                return;
            }

            // Mettre à jour le versement
            if ($this->scolariteModel->mettreAJourVersement($id_versement, $montant, $date_versement, $methode_paiement)) {
                $GLOBALS['messageSuccess'] = "Versement mis à jour avec succès.";
            } else {
                $GLOBALS['messageErreur'] = "Erreur lors de la mise à jour du versement.";
            }
        }
    }

    public function supprimerVersement() {
        // Initialize message variables
        $messageErreur = '';
        $messageSuccess = '';
        
        // Gérer la suppression via une requête POST (recommandé pour les suppressions)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Récupérer l'ID du versement depuis la requête (GET ou POST, selon comment le JS l'envoie)
             $id_versement = $_REQUEST['id'] ?? null; // Utiliser $_REQUEST pour gérer GET ou POST

            // Vérifier si la requête est AJAX pour renvoyer du JSON
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

            if ($id_versement) {
                try {
                    if ($this->scolariteModel->deleteVersement($id_versement)) {
                         if ($isAjax) {
                             header('Content-Type: application/json');
                             echo json_encode(['success' => true, 'message' => 'Versement supprimé avec succès.']);
                         } else {
                             $GLOBALS['messageSuccess'] = "Versement supprimé avec succès.";
                            
                         }
                    } else {
                         if ($isAjax) {
                             header('Content-Type: application/json');
                             echo json_encode(['success' => false, 'message' => 'Échec de la suppression du versement.']);
                         } else {
                              $GLOBALS['messageErreur'] = "Échec de la suppression du versement.";
                           
                         }
                    }
                } catch (Exception $e) {
                     if ($isAjax) {
                         header('Content-Type: application/json');
                         echo json_encode(['success' => false, 'message' => 'Erreur serveur: ' . $e->getMessage()]);
                     } else {
                         $GLOBALS['messageErreur'] = "Erreur serveur lors de la suppression: " . $e->getMessage();
                         header('Location: ?page=gestion_scolarite');
                     }
                }
            } else {
                 if ($isAjax) {
                     header('Content-Type: application/json');
                     echo json_encode(['success' => false, 'message' => 'ID de versement manquant.']);
                 } else {
                     $GLOBALS['messageErreur'] = "ID de versement manquant.";
                     
                 }
            }
            exit(); // Assurez-vous de sortir après l'envoi de la réponse JSON ou la redirection
        } else {
            // Si ce n'est pas une requête POST, rediriger ou afficher un message d'erreur
            $GLOBALS['messageErreur'] = "Méthode non autorisée.";
             
        }
    }

    public function imprimerRecu() {
        // Récupérer l'ID du versement depuis l'URL (GET)
        $id_versement = $_GET['id'] ?? null;

        if ($id_versement) {
            $versement = $this->scolariteModel->getVersementById($id_versement);

            if ($versement) {
                // Préparer les données pour le reçu
                $GLOBALS['versementPourRecu'] = $versement;

                // Inclure la vue spécifique pour le reçu (à créer)
                require_once __DIR__ . '/../ressources/views/recu_versement.php'; // Il faudra créer ce fichier

            } else {
                echo "<p>Reçu introuvable.</p>"; // Gérer l'erreur d'affichage du reçu
            }
        } else {
            echo "<p>ID de versement manquant.</p>"; // Gérer l'erreur d'ID manquant
        }
    }

}

?>