<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Action.php';
require_once __DIR__ . '/../models/AnneeAcademique.php';
require_once __DIR__ . '/../models/Ecue.php';
require_once __DIR__ . '/../models/Fonction.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/GroupeUtilisateur.php';
require_once __DIR__ . '/../models/NiveauAccesDonnees.php';
require_once __DIR__ . '/../models/NiveauApprobation.php';
require_once __DIR__ . '/../models/Specialite.php';
require_once __DIR__ . '/../models/StatutJury.php';
require_once __DIR__ . '/../models/TypeUtilisateur.php';
require_once __DIR__ . '/../models/Ue.php';
require_once __DIR__ . '/../models/NiveauEtude.php';
require_once __DIR__ . '/../models/Semestre.php';
require_once __DIR__ . '/../models/Traitement.php';
require_once __DIR__ . '/../models/Entreprise.php';
require_once __DIR__ . '/../models/Message.php';

class ParametreController
{
    private $baseViewPath;
    private $action;
    private $anneeAcademique;
    private $ecue;
    private $fonction;
    private $grade;
    private $groupeUtilisateur;
    private $niveauAccesDonnees;
    private $niveauApprobation;
    private $niveauEtude;
    private $specialite;
    private $statutJury;
    private $typeUtilisateur;
    private $ue;
    private $semestre;
    private $entreprise;
    private $traitement;
    private $message;

    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/admin/partials/parametres_generaux/';
        $this->anneeAcademique = new AnneeAcademique(Database::getConnection());
        $this->action = new Action(Database::getConnection());
        $this->fonction = new Fonction(Database::getConnection());
        $this->grade = new Grade(Database::getConnection());
        $this->groupeUtilisateur = new GroupeUtilisateur(Database::getConnection());
        $this->niveauAccesDonnees = new NiveauAccesDonnees(Database::getConnection());
        $this->niveauApprobation = new NiveauApprobation(Database::getConnection());
        $this->typeUtilisateur = new TypeUtilisateur(Database::getConnection());
        $this->ue = new Ue(Database::getConnection());
        $this->ecue = new Ecue(Database::getConnection());
        $this->statutJury = new StatutJury(Database::getConnection());
        $this->specialite = new Specialite(Database::getConnection());
        $this->niveauEtude = new NiveauEtude(Database::getConnection());
        $this->semestre = new Semestre(Database::getConnection());
        $this->traitement = new Traitement(Database::getConnection());
        $this->entreprise = new Entreprise(Database::getConnection());
        $this->message = new Message(Database::getConnection());
    }


    //=============================GESTION ANNEE ACADEMIQUE=============================
    public function gestionAnnees()
    {
        $annee_a_modifier = null;
        $messageErreur = null;


        // Ajout ou modification
        if (isset($_POST['btn_add_annees_academiques']) || isset($_POST['btn_modifier_annees_academiques'])) {
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];


            if ($dateDebut >= $dateFin) {
                $messageErreur = "L'année Academique n'est pas valide";
            } else {
                if (!empty($_POST['id_annee_acad'])) {
                    // MODIFICATION
                    $this->anneeAcademique->updateAnneeAcademique($_POST['id_annee_acad'], $dateDebut, $dateFin);
                } else {
                    // AJOUT
                    $this->anneeAcademique->ajouterAnneeAcademique($dateDebut, $dateFin);
                }
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && $_POST['submit_delete_multiple'] == '1' && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->anneeAcademique->deleteAnneeAcademique($id);
            }

            // Redirection après suppression
            header("Location: ?page=parametres_generaux&action=annees_academiques");
            exit();
        }

        // Récupération de l'année à modifier pour affichage dans le formulaire
        if (isset($_GET['id_annee_acad'])) {
            $annee_a_modifier = $this->anneeAcademique->getAnneeAcademiqueById($_GET['id_annee_acad']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['annee_a_modifier'] = $annee_a_modifier;
        $GLOBALS['listeAnnees'] = $this->anneeAcademique->getAllAnneeAcademiques();
    }
    //=============================FIN GESTION ANNEE ACADEMIQUE=============================


    //=============================GESTION GRADES=============================
    public
    function gestionGrade()
    {

        $grades_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_grades'])) {
            $lib_grade = $_POST['grades'];

            if (!empty($_POST['id_grade'])) {
                // MODIFICATION
                $this->grade->updateGrade($_POST['id_grade'], $lib_grade);
            } else {
                // AJOUT
                $this->grade->ajouterGrade($lib_grade);
            }
        }


        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->grade->deleteGrade($id);
            }
        }

        // Récupération du grade à modifier pour affichage dans le formulaire
        if (isset($_GET['id_grade'])) {
            $grades_a_modifier = $this->grade->getGradeById($_GET['id_grade']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['grade_a_modifier'] = $grades_a_modifier;
        $GLOBALS['listeGrade'] = $this->grade->getAllGrades();
    }
    //=============================FIN GESTION GRADES=============================


    //=============================GESTION FONCTION UTILISATEUR=============================
    public function gestionFonctionUtilisateur()
    {
        $groupe_a_modifier = null;
        $type_a_modifier = null;


        //======PARTIE GROUPE UTILISATEUR======

        //Ajout ou modification
        if (isset($_GET['tab']) && $_GET['tab'] === 'groupes') {
            //Ajout ou modif
            if (isset($_POST['submit_add_groupe'])) {
                $lib_groupe = $_POST['lib_groupe'];

                if (!empty($_POST['id_groupe'])) {
                    //MODIF
                    $this->groupeUtilisateur->updateGroupeUtilisateur($_POST['id_groupe'], $lib_groupe);
                } else {
                    //AJOUT
                    $this->groupeUtilisateur->ajouterGroupeUtilisateur($lib_groupe);
                }
            }

            // Suppression multiple
            if (isset($_POST['submit_delete_multiple_groupe']) && isset($_POST['selected_ids'])) {
                foreach ($_POST['selected_ids'] as $id) {
                    $this->groupeUtilisateur->deleteGroupeUtilisateur($id);
                }
            }

            // Récupération du grade à modifier pour affichage dans le formulaire
            if (isset($_GET['id_groupe'])) {
                $groupe_a_modifier = $this->groupeUtilisateur->getGroupeUtilisateurById($_GET['id_groupe']);
            }

            // 📦 Variables disponibles pour la vue
            $GLOBALS['groupe_a_modifier'] = $groupe_a_modifier;
            $GLOBALS['listeGroupes'] = $this->groupeUtilisateur->getAllGroupeUtilisateur();
        }
        //======FIN PARTIE GROUPE UTILISATEUR======


        //======PARTIE TYPE UTILISATEUR======
        if (isset($_GET['tab']) && $_GET['tab'] == 'types') {
            //Ajout ou modif
            if (isset($_POST['submit_add_type'])) {
                $lib_type_utilisateur = $_POST['lib_type_utilisateur'];
                if (!empty($_POST['id_type_utilisateur'])) {
                    //MODIF
                    $this->typeUtilisateur->updateTypeUtilisateur($_POST['id_type_utilisateur'], $lib_type_utilisateur);
                } else {
                    //AJOUT
                    $this->typeUtilisateur->ajouterTypeUtilisateur($lib_type_utilisateur);
                }
            }

            // Suppression multiple
            if (isset($_POST['submit_delete_multiple_type']) && isset($_POST['selected_ids'])) {
                foreach ($_POST['selected_ids'] as $id) {
                    $this->typeUtilisateur->deleteTypeUtilisateur($id);
                }
            }

            // Récupération du grade à modifier pour affichage dans le formulaire
            if (isset($_GET['id_type'])) {
                $type_a_modifier = $this->typeUtilisateur->getTypeUtilisateurById($_GET['id_type']);
            }

            // 📦 Variables disponibles pour la vue
            $GLOBALS['type_a_modifier'] = $type_a_modifier;
            $GLOBALS['listeTypes'] = $this->typeUtilisateur->getAllTypeUtilisateur();
        }

    }
//=============================FIN GESTION FONCTION UTILISATEUR=============================


//=============================GESTION SPECIALITE=============================
    public function gestionSpecialite()
    {
        $specialite_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_specialite'])) {
            $lib_specialite = $_POST['specialite'];

            if (!empty($_POST['id_specialite'])) {
                // MODIFICATION
                $this->specialite->updateSpecialite($_POST['id_specialite'], $lib_specialite);
            } else {
                // AJOUT
                $this->specialite->ajouterSpecialite($lib_specialite);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->specialite->deleteSpecialite($id);
            }
        }

        // Récupération de la spécialité à modifier pour affichage dans le formulaire
        if (isset($_GET['id_specialite'])) {
            $specialite_a_modifier = $this->specialite->getSpecialiteById($_GET['id_specialite']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['specialite_a_modifier'] = $specialite_a_modifier;
        $GLOBALS['listeSpecialites'] = $this->specialite->getAllSpecialites();
    }
    //=============================FIN GESTION SPECIALITE=============================


    //=============================GESTION NIVEAU ETUDE=============================
    public function gestionNiveauEtude()
    {
        $niveau_a_modifier = null;

        if (isset($_POST['btn_add_niveau_etude'])) {
            $lib_niveau = $_POST['niveau_etude'];

            if (!empty($_POST['id_niveau_etude'])) {
                $this->niveauEtude->updateNiveauEtude($_POST['id_niveau_etude'], $lib_niveau);
            } else {
                $this->niveauEtude->ajouterNiveauEtude($lib_niveau);
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->niveauEtude->deleteNiveauEtude($id);
            }
        }

        if (isset($_GET['id_niveau_etude'])) {
            $niveau_a_modifier = $this->niveauEtude->getNiveauEtudeById($_GET['id_niveau_etude']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauEtude->getAllNiveauxEtudes();
    }
    //=============================FIN GESTION NIVEAU ETUDE=============================


    //=============================GESTION UE=============================
    public function gestionUe()
    {
        $ue_a_modifier = null;

        if (isset($_POST['submit_add_ue'])) {
            $lib_ue = $_POST['lib_ue'];
            $credit = $_POST['credits'];
            $id_niveau_etude = $_POST['niveau'];
            $id_semestre = $_POST['semestre'];
            $id_annee = $_POST['annee_academiques'];

            if (!empty($_POST['id_ue'])) {
                $this->ue->updateUe($_POST['id_ue'], $lib_ue, $id_niveau_etude, $id_semestre, $id_annee, $credit);
            } else {
                $this->ue->ajouterUe($lib_ue, $id_niveau_etude, $id_semestre, $id_annee, $credit);
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->ue->deleteUe($id);
            }
        }

        if (isset($_GET['id_ue'])) {
            $ue_a_modifier = $this->ue->getUeById($_GET['id_ue']);
        }

        $GLOBALS['ue_a_modifier'] = $ue_a_modifier;
        $GLOBALS['listeUes'] = $this->ue->getAllUes();
        $GLOBALS['listeNiveauxEtude'] = $this->niveauEtude->getAllNiveauxEtudes();
        $GLOBALS['listeSemestres'] = $this->semestre->getAllSemestres();
        $GLOBALS['listeAnnees'] = $this->anneeAcademique->getAllAnneeAcademiques();
    }
    //=============================FIN GESTION UE=============================


    //=============================GESTION ECUE=============================
    public function gestionEcue()
    {
        $ecue_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['submit_add_ecue'])) {
            $id_ue = $_POST['ue'];
            $lib_ecue = $_POST['lib_ecue'];
            $credit = $_POST['credits'];

            if (!empty($_POST['id_ecue'])) {
                $result = $this->ecue->updateEcue($_POST['id_ecue'], $id_ue, $lib_ecue, $credit);
            } else {
                $result = $this->ecue->ajouterEcue($id_ue, $lib_ecue, $credit);
            }

            if (!$result) {
                $GLOBALS['error_credit'] = "Le total des crédits ECUE dépasserait celui de l’UE.";
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->ecue->deleteEcue($id);
            }
        }

        // Préparation pour modification
        if (isset($_GET['id_ecue'])) {
            $ecue_a_modifier = $this->ecue->getEcueById($_GET['id_ecue']);
        }

        // 📦 Variables envoyées à la vue
        $GLOBALS['ecue_a_modifier'] = $ecue_a_modifier;
        $GLOBALS['listeEcues'] = $this->ecue->getAllEcues();
        $GLOBALS['listeUes'] = $this->ue->getAllUes();
    }

    //=============================FIN GESTION ECUE=============================


    //=============================GESTION STATUT JURY=============================
    public function gestionStatutJury()
    {
        $statut_a_modifier = null;

        if (isset($_POST['btn_add_statut_jury'])) {
            $lib_statut = $_POST['statut_jury'];

            if (!empty($_POST['id_statut_jury'])) {
                $this->statutJury->updateStatutJury($_POST['id_statut_jury'], $lib_statut);
            } else {
                $this->statutJury->ajouterStatutJury($lib_statut);
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->statutJury->deleteStatutJury($id);
            }
        }

        if (isset($_GET['id_statut_jury'])) {
            $statut_a_modifier = $this->statutJury->getStatutJuryById($_GET['id_statut_jury']);
        }

        $GLOBALS['statut_a_modifier'] = $statut_a_modifier;
        $GLOBALS['listeStatuts'] = $this->statutJury->getAllStatutsJury();
    }
    //=============================FIN GESTION STATUT JURY=============================


    //=============================GESTION NIVEAU APPROBATION=============================
    public function gestionNiveauApprobation()
    {
        $niveau_a_modifier = null;

        if (isset($_POST['btn_add_niveau_approbation'])) {
            $lib_niveau = $_POST['niveaux_approbation'];

            if (!empty($_POST['id_approb'])) {
                $this->niveauApprobation->updateNiveauApprobation($_POST['id_approb'], $lib_niveau);
            } else {
                $this->niveauApprobation->ajouterNiveauApprobation($lib_niveau);
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->niveauApprobation->deleteNiveauApprobation($id);
            }
        }

        if (isset($_GET['id_approb'])) {
            $niveau_a_modifier = $this->niveauApprobation->getNiveauApprobationById($_GET['id_approb']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauApprobation->getAllNiveauxApprobation();
    }
    //=============================FIN GESTION NIVEAU APPROBATION=============================


//=============================GESTION SEMESTRES=============================
    public function gestionSemestre()
    {
        $semestre_a_modifier = null;

        if (isset($_POST['btn_add_semestres'])) {
            $lib_semestre = $_POST['semestres'];

            if (!empty($_POST['id_semestre'])) {
                $this->semestre->updateSemestre($_POST['id_semestre'], $lib_semestre);
            } else {
                $this->semestre->ajouterSemestre($lib_semestre);
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->semestre->deleteSemestre($id);
            }
        }

        if (isset($_GET['id_semestre'])) {
            $semestre_a_modifier = $this->semestre->getSemestreById($_GET['id_semestre']);
        }

        $GLOBALS['semestre_a_modifier'] = $semestre_a_modifier;
        $GLOBALS['listeSemestres'] = $this->semestre->getAllSemestres();
    }
//=============================FIN GESTION SEMESTRES=============================


//=============================GESTION NIVEAU ACCES DONNEES=============================
    public function gestionNiveauAccesDonnees()
    {
        $niveau_a_modifier = null;

        if (isset($_POST['btn_add_niveau_acces_donnees'])) {
            $lib_niveau = $_POST['niveau_acces_donnees'];

            if (!empty($_POST['id_niveau_acces'])) {
                $this->niveauAccesDonnees->updateNiveauAccesDonnees($_POST['id_niveau_acces'], $lib_niveau);
            } else {
                $this->niveauAccesDonnees->ajouterNiveauAccesDonnees($lib_niveau);
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->niveauAccesDonnees->deleteNiveauAccesDonnees($id);
            }
        }

        if (isset($_GET['id_niveau_acces'])) {
            $niveau_a_modifier = $this->niveauAccesDonnees->getNiveauAccesDonneesById($_GET['id_niveau_acces']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauAccesDonnees->getAllNiveauxAccesDonnees();
    }
    //=============================FIN GESTION NIVEAU ACCES DONNEES=============================


    //=============================GESTION TRAITEMENT=============================
    public function gestionTraitement()
    {
        $traitement_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_traitement'])) {
            $lib_traitement = $_POST['traitement'];

            if (!empty($_POST['id_traitement'])) {
                // MODIFICATION
                $this->traitement->updateTraitement($_POST['id_traitement'], $lib_traitement);
            } else {
                // AJOUT
                $this->traitement->ajouterTraitement($lib_traitement);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->traitement->deleteTraitement($id);
            }
        }

        // Récupération du traitement à modifier pour affichage dans le formulaire
        if (isset($_GET['id_traitement'])) {
            $traitement_a_modifier = $this->traitement->getTraitementById($_GET['id_traitement']);
        }

        // Variables disponibles pour la vue
        $GLOBALS['traitement_a_modifier'] = $traitement_a_modifier;
        $GLOBALS['listeTraitements'] = $this->traitement->getAllTraitements();
    }
//=============================FIN GESTION TRAITEMENT============================


    //=============================GESTION ENTREPRISE=============================
    public function gestionEntreprise()
    {
        $entreprise_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_entreprise'])) {
            $lib_entreprise = $_POST['entreprise'];

            if (!empty($_POST['id_entreprise'])) {
                // MODIFICATION
                $this->entreprise->updateEntreprise($_POST['id_entreprise'], $lib_entreprise);
            } else {
                // AJOUT
                $this->entreprise->ajouterEntreprise($lib_entreprise);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->entreprise->deleteEntreprise($id);
            }
        }

        // Récupération de l'entreprise à modifier pour affichage dans le formulaire
        if (isset($_GET['id_entreprise'])) {
            $entreprise_a_modifier = $this->entreprise->getEntrepriseById($_GET['id_entreprise']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['entreprise_a_modifier'] = $entreprise_a_modifier;
        $GLOBALS['listeEntreprises'] = $this->entreprise->getAllEntreprises();
    }
//=============================FIN GESTION ENTREPRISE============================

//=============================GESTION ACTION=============================
    public function gestionAction()
    {
        $action_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_action']) || isset($_POST['btn_modifier_action'])) {
            $lib_action = $_POST['action'];


            if (!empty($_POST['id_action'])) {
                // MODIFICATION
                $this->action->updateAction($_POST['id_action'], $lib_action);
            } else {
                // AJOUT
                $this->action->ajouterAction($lib_action);
            }
        }


        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->action->deleteAction($id);
            }
        }

        // Récupération de l'action à modifier pour affichage dans le formulaire
        if (isset($_GET['id_action'])) {
            $action_a_modifier = $this->action->getActionById($_GET['id_action']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['action_a_modifier'] = $action_a_modifier;
        $GLOBALS['listeActions'] = $this->action->getAllAction();
    }
//=============================FIN GESTION ACTION============================

//=============================GESTION FONCTION=============================
    public function gestionFonction()
    {
        $fonction_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_fonction'])) {
            $lib_fonction = $_POST['fonction'];

            if (!empty($_POST['id_fonction'])) {
                // MODIFICATION
                $this->fonction->updateFonction($_POST['id_fonction'], $lib_fonction);
            } else {
                // AJOUT
                $this->fonction->ajouterFonction($lib_fonction);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->fonction->deleteFonction($id);
            }
        }

        // Récupération de la fonction à modifier pour affichage dans le formulaire
        if (isset($_GET['id_fonction'])) {
            $fonction_a_modifier = $this->fonction->getFonctionById($_GET['id_fonction']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['fonction_a_modifier'] = $fonction_a_modifier;
        $GLOBALS['listeFonctions'] = $this->fonction->getAllFonction();
    }
//=============================FIN GESTION FONCTION============================

//=============================GESTION MESSAGERIE=============================
    public function gestionMessagerie()
    {
        $message_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_message'])) {
            $contenu_message = $_POST['message'];

            if (!empty($_POST['id_message'])) {
                // MODIFICATION
                $this->message->updateMessage($_POST['id_message'], $contenu_message);
            } else {
                // AJOUT
                $this->message->ajouterMessage($contenu_message);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->message->deleteMessage($id);
            }
        }

        // Récupération du message à modifier pour affichage dans le formulaire
        if (isset($_GET['id_message'])) {
            $message_a_modifier = $this->message->getMessageById($_GET['id_message']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['message_a_modifier'] = $message_a_modifier;
        $GLOBALS['listeMessages'] = $this->message->getAllMessages();
    }
//=============================FIN GESTION MESSAGERIE============================


}
/*Ce fichier est le contrôleur principal pour la gestion des paramètres généraux de l'application.
    Il gère les actions liées aux entités telles que les années académiques, les grades, les ECUE, etc.
    Chaque méthode correspond à une fonctionnalité spécifique et interagit avec le modèle approprié. */