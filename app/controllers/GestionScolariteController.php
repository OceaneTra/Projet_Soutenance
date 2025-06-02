<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Scolarite.php';

class GestionScolariteController {
    private $scolariteModel;

    public function __construct($db) {
        $this->scolariteModel = new Scolarite($db);
    }

    public function index() {
        // Récupérer la liste des versements
        $versements = $this->scolariteModel->getAllVersements();
        // Récupérer la liste des étudiants inscrits pour le formulaire d'ajout
        $etudiantsInscrits = $this->scolariteModel->getEtudiantsInscrits(); // Assurez-vous que cette méthode existe et renvoie les bonnes données

        // Passer les données à la vue via les variables globales (ou un autre mécanisme si votre framework le permet)
        $GLOBALS['versements'] = $versements;
        $GLOBALS['etudiantsInscrits'] = $etudiantsInscrits;

        
    }

    public function enregistrerVersement() {
        // Valider les données du formulaire POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id_etudiant = $_POST['id_etudiant'] ?? null;
            $montant = $_POST['montant'] ?? null;
            $date_versement = $_POST['date_versement'] ?? null;
            $methode_paiement = $_POST['methode_paiement'] ?? null;

            // Récupérer l'id_inscription à partir de l'id_etudiant
            // Il faudrait une méthode dans le modèle pour obtenir l'id_inscription d'un étudiant inscrit
            $inscription = $this->scolariteModel->getInscriptionByEtudiantId($id_etudiant); // Cette méthode doit être créée

            if ($id_etudiant && $montant && $date_versement && $methode_paiement && $inscription) {
                $data = [
                    'id_inscription' => $inscription['id_inscription'],
                    'montant' => $montant,
                    'date_versement' => $date_versement,
                    'type' => 'Tranche',
                    'methode_paiement' => $methode_paiement
                ];

                if ($this->scolariteModel->addVersement($data)) {
                    $GLOBALS['messageSuccess'] = "Versement enregistré avec succès.";
                } else {
                    $GLOBALS['messageErreur'] = "Erreur lors de l'enregistrement du versement.";
                }
            } else {
                $GLOBALS['messageErreur'] = "Veuillez remplir tous les champs requis.";
            }
        }

        // Rediriger ou afficher la page avec les messages
         header('Location: ?page=gestion_scolarite'); // Redirige vers la page de liste
         exit();
    }

     public function modifierVersement() {
         // Récupérer l'ID du versement depuis l'URL (GET)
         $id_versement = $_GET['id'] ?? null;

         if ($id_versement) {
             $versementAModifier = $this->scolariteModel->getVersementById($id_versement);
             $etudiantsInscrits = $this->scolariteModel->getEtudiantsInscrits(); // Nécessaire pour le select dans le formulaire

             if ($versementAModifier) {
                 $GLOBALS['versementAModifier'] = $versementAModifier;
                 $GLOBALS['etudiantsInscrits'] = $etudiantsInscrits; // Passer aussi les étudiants pour le select
            } else {
                $GLOBALS['messageErreur'] = "Versement introuvable.";
            }
         } else {
             $GLOBALS['messageErreur'] = "ID de versement manquant.";
            
         }
     }

     public function mettreAJourVersement() {
        // Gérer la soumission du formulaire de modification (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_versement = $_POST['id_versement'] ?? null; // Assurez-vous d'ajouter un champ caché pour l'id dans le formulaire de modif
            $montant = $_POST['montant'] ?? null;
            $date_versement = $_POST['date_versement'] ?? null;
            $methode_paiement = $_POST['methode_paiement'] ?? null;
             // id_etudiant pourrait potentiellement aussi être modifié? Dépend des règles métier.

            if ($id_versement && $montant && $date_versement && $methode_paiement) {
                 $data = [
                     'montant' => $montant,
                     'date_versement' => $date_versement,
                     'methode_paiement' => $methode_paiement
                      // Type de versement si modifiable
                 ];

                if ($this->scolariteModel->updateVersement($id_versement, $data)) {
                    $GLOBALS['messageSuccess'] = "Versement mis à jour avec succès.";
                } else {
                    $GLOBALS['messageErreur'] = "Erreur lors de la mise à jour du versement.";
                }
            } else {
                $GLOBALS['messageErreur'] = "Veuillez remplir tous les champs requis.";
            }
        }
     }

    public function supprimerVersement() {
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
                             header('Location: ?page=gestion_scolarite');
                         }
                    } else {
                         if ($isAjax) {
                             header('Content-Type: application/json');
                             echo json_encode(['success' => false, 'message' => 'Échec de la suppression du versement.']);
                         } else {
                              $GLOBALS['messageErreur'] = "Échec de la suppression du versement.";
                             header('Location: ?page=gestion_scolarite');
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
                     header('Location: ?page=gestion_scolarite');
                 }
            }
            exit(); // Assurez-vous de sortir après l'envoi de la réponse JSON ou la redirection
        } else {
            // Si ce n'est pas une requête POST, rediriger ou afficher un message d'erreur
            $GLOBALS['messageErreur'] = "Méthode non autorisée.";
             header('Location: ?page=gestion_scolarite');
             exit();
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

    // Méthode à ajouter au modèle Scolarite pour obtenir l'id_inscription par id_etudiant
    // public function getInscriptionByEtudiantId($id_etudiant) { ... }

     // Méthode à ajouter au modèle Scolarite pour obtenir la liste des étudiants inscrits (si non déjà présente)
     // public function getEtudiantsInscrits() { ... }
}

?>