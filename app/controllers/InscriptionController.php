<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Scolarite.php';


class InscriptionController {
    private $scolarite;

    public function __construct() {
        $this->scolarite = new Scolarite(Database::getConnection());
    }

    public function index() {
        $messageErreur = '';
        $messageSuccess = '';

        

        // Gestion de la requête AJAX pour obtenir les informations d'un étudiant
        if (isset($_GET['action']) && $_GET['action'] === 'get_etudiant' && isset($_GET['num_etu'])) {
            $etudiant = $this->scolarite->getInfoEtudiant($_GET['num_etu']);
            header('Content-Type: application/json');
            echo json_encode($etudiant);
            exit;
        }

        // Gestion de la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = $_POST['etudiant'];
            $id_niveau = $_POST['niveau'];
            $montant_premier_versement = $_POST['premier_versement'];
            $nombre_tranches = $_POST['nombre_tranches'];

            try {
                // Créer l'inscription
                $id_inscription = $this->scolarite->creerInscription(
                    $id_etudiant,
                    $id_niveau,
                    $montant_premier_versement
                );

                // Calculer le montant des tranches
                $montant_total = $this->scolarite->getMontantScolarite($id_niveau);
                $reste_a_payer = $montant_total - $montant_premier_versement;
                $montant_tranche = $reste_a_payer / $nombre_tranches;

                // Créer les échéances
                $date_actuelle = new DateTime();
                for ($i = 1; $i <= $nombre_tranches; $i++) {
                    $date_echeance = clone $date_actuelle;
                    $date_echeance->modify("+$i month");
                    
                    $this->scolarite->creerEcheance(
                        $id_inscription,
                        $montant_tranche,
                        $date_echeance->format('Y-m-d')
                    );
                }

                $messageSuccess = "L'inscription a été enregistrée avec succès.";
                // Rafraîchir la liste des étudiants inscrits
                $GLOBALS['etudiantsInscrits'] = $this->scolarite->getEtudiantsInscrits();
            } catch (Exception $e) {
                $messageErreur = "Une erreur est survenue lors de l'inscription : " . $e->getMessage();
            }
        }

        // Définir les variables globales pour la vue
        $GLOBALS['etudiantsInscrits'] = $this->scolarite->getEtudiantsInscrits();
        $GLOBALS['etudiantsNonInscrits'] = $this->scolarite->getEtudiantsNonInscrits();
        $GLOBALS['niveaux'] = $this->scolarite->getNiveauxEtudes();
        $GLOBALS['messageSuccess'] = $messageSuccess;
        $GLOBALS['messageErreur'] = $messageErreur;

      
    }
} 