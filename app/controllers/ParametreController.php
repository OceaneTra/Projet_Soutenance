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
require_once __DIR__ . '/../models/NiveauEtude.php';
require_once __DIR__ . '/../models/Specialite.php';
require_once __DIR__ . '/../models/StatutJury.php';
require_once __DIR__ . '/../models/TypeUtilisateur.php';
require_once __DIR__ . '/../models/Ue.php';
require_once __DIR__ . '/../models/NiveauEtude.php';

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
    }


    //=============================GESTION ANNEE ACADEMIQUE=============================
    public function gestionAnnees()
    {
        $annee_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_annees_academiques'])) {
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];

            if (!empty($_POST['id_annee_acad'])) {
                // MODIFICATION
                $this->anneeAcademique->updateAnneeAcademique($_POST['id_annee_acad'], $dateDebut, $dateFin);
            } else {
                // AJOUT
                $this->anneeAcademique->ajouterAnneeAcademique($dateDebut, $dateFin);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->anneeAcademique->deleteAnneeAcademique($id);
            }
        }

        // Récupération de l’année à modifier pour affichage dans le formulaire
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
        function gestionGrade(
    ) {

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


    /*


    //=============================GESTION ECUE=============================
    public function gestionEcue()
    {
        $ecue_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_ecue'])) {
            $lib_ecue = $_POST['ecue'];

            if (!empty($_POST['id_ecue'])) {
                // MODIFICATION
                $this->ecue->updateEcue($_POST['id_ecue'], $lib_ecue);
            } else {
                // AJOUT
                $this->ecue->addEcue($lib_ecue);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->ecue->deleteEcue($id);
            }
        }

        // Récupération de l'ECUE à modifier pour affichage dans le formulaire
        if (isset($_GET['id_ecue'])) {
            $ecue_a_modifier = $this->ecue->getEcueById($_GET['id_ecue']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['ecue_a_modifier'] = $ecue_a_modifier;
        $GLOBALS['listeEcues'] = $this->ecue->getAllEcues();
    }
    //=============================FIN GESTION ECUE=============================


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
                $this->fonction->addFonction($lib_fonction);
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
        $GLOBALS['listeFonctions'] = $this->fonction->getAllFonctions();
    }
    //=============================FIN GESTION FONCTION=============================

    //=============================GESTION GROUPE UTILISATEUR=============================
    public function gestionGroupeUtilisateur()
    {
        $groupe_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_groupe_utilisateur'])) {
            $lib_groupe = $_POST['groupe_utilisateur'];

            if (!empty($_POST['id_groupe_utilisateur'])) {
                // MODIFICATION
                $this->groupeUtilisateur->updateGroupeUtilisateur($_POST['id_groupe_utilisateur'], $lib_groupe);
            } else {
                // AJOUT
                $this->groupeUtilisateur->ajouterGroupeUtilisateur($lib_groupe);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->groupeUtilisateur->deleteGroupeUtilisateur($id);
            }
        }

        // Récupération du groupe à modifier pour affichage dans le formulaire      
        if (isset($_GET['id_groupe_utilisateur'])) {
            $groupe_a_modifier = $this->groupeUtilisateur->getGroupeUtilisateurById($_GET['id_groupe_utilisateur']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['groupe_a_modifier'] = $groupe_a_modifier;
        $GLOBALS['listeGroupes'] = $this->groupeUtilisateur->getAllGroupesUtilisateurs();
    }
    //=============================FIN GESTION GROUPE UTILISATEUR=============================


    //=============================GESTION NIVEAU ACCES DONNEES=============================
    public function gestionNiveauAccesDonnees()
    {
        $niveau_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_niveau_acces_donnees'])) {
            $lib_niveau = $_POST['niveau_acces_donnees'];

            if (!empty($_POST['id_niveau_acces_donnees'])) {
                // MODIFICATION
                $this->niveauAccesDonnees->updateNiveauAccesDonnees($_POST['id_niveau_acces_donnees'], $lib_niveau);
            } else {
                // AJOUT
                $this->niveauAccesDonnees->ajouterNiveauAccesDonnees($lib_niveau);
            }
        }
        // Suppression multiple         
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->niveauAccesDonnees->deleteNiveauAccesDonnees($id);
            }
        }
        // Récupération du niveau à modifier pour affichage dans le formulaire
        if (isset($_GET['id_niveau_acces_donnees'])) {
            $niveau_a_modifier = $this->niveauAccesDonnees->getNiveauAccesDonneesById($_GET['id_niveau_acces_donnees']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauAccesDonnees->getAllNiveauxAccesDonnees();
    }
    //=============================FIN GESTION NIVEAU ACCES DONNEES=============================

    //=============================GESTION NIVEAU APPROBATION=============================
    public function gestionNiveauApprobation()
    {
        $niveau_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_niveau_approbation'])) {
            $lib_niveau = $_POST['niveau_approbation'];

            if (!empty($_POST['id_niveau_approbation'])) {
                // MODIFICATION
                $this->niveauApprobation->updateNiveauApprobation($_POST['id_niveau_approbation'], $lib_niveau);
            } else {
                // AJOUT
                $this->niveauApprobation->ajouterNiveauApprobation($lib_niveau);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->niveauApprobation->deleteNiveauApprobation($id);
            }
        }
        // Récupération du niveau à modifier pour affichage dans le formulaire
        if (isset($_GET['id_niveau_approbation'])) {
            $niveau_a_modifier = $this->niveauApprobation->getNiveauApprobationById($_GET['id_n
iveau_approbation']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauApprobation->getAllNiveauxApprobation();
    }
    //=============================FIN GESTION NIVEAU APPROBATION=============================  

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

    //=============================GESTION STATUT JURY=============================
    public function gestionStatutJury()
    {
        $statut_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_statut_jury'])) {
            $lib_statut = $_POST['statut_jury'];

            if (!empty($_POST['id_statut_jury'])) {
                // MODIFICATION
                $this->statutJury->updateStatutJury($_POST['id_statut_jury'], $lib_statut);
            } else {
                // AJOUT
                $this->statutJury->ajouterStatutJury($lib_statut);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->statutJury->deleteStatutJury($id);
            }
        }
        // Récupération du statut à modifier pour affichage dans le formulaire
        if (isset($_GET['id_statut_jury'])) {
            $statut_a_modifier = $this->statutJury->getStatutJuryById($_GET['id_statut_jury']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['statut_a_modifier'] = $statut_a_modifier;
        $GLOBALS['listeStatuts'] = $this->statutJury->getAllStatutsJury();
    }
    //=============================FIN GESTION STATUT JURY=============================

    //=============================GESTION TYPE UTILISATEUR=============================
    public function gestionTypeUtilisateur()
    {
        $type_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_type_utilisateur'])) {
            $lib_type = $_POST['type_utilisateur'];

            if (!empty($_POST['id_type_utilisateur'])) {
                // MODIFICATION
                $this->typeUtilisateur->updateTypeUtilisateur($_POST['id_type_utilisateur'], $lib_type);
            } else {
                // AJOUT
                $this->typeUtilisateur->ajouterTypeUtilisateur($lib_type);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->typeUtilisateur->deleteTypeUtilisateur($id);
            }
        }
        // Récupération du type à modifier pour affichage dans le formulaire
        if (isset($_GET['id_type_utilisateur'])) {
            $type_a_modifier = $this->typeUtilisateur->getTypeUtilisateurById($_GET['id_type_utilisateur']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['type_a_modifier'] = $type_a_modifier;
        $GLOBALS['listeTypes'] = $this->typeUtilisateur->getAllTypesUtilisateurs();
    }
    //=============================FIN GESTION TYPE UTILISATEUR=============================


    //=============================GESTION NIVEAU ETUDE=============================
    public function gestionNiveauEtude()
    {
        $niveau_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_niveau_etude'])) {
            $lib_niveau = $_POST['niveau_etude'];

            if (!empty($_POST['id_niveau_etude'])) {
                // MODIFICATION
                $this->niveauEtude->updateNiveauEtude($_POST['id_niveau_etude'], $lib_niveau);
            } else {
                // AJOUT
                $this->niveauEtude->ajouterNiveauEtude($lib_niveau);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->niveauEtude->deleteNiveauEtude($id);
            }
        }
        // Récupération du niveau à modifier pour affichage dans le formulaire
        if (isset($_GET['id_niveau_etude'])) {
            $niveau_a_modifier = $this->niveauEtude->getNiveauEtudeById($_GET['id_niveau_etude']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauEtude->getAllNiveauxEtudes();
    }
    //=============================FIN GESTION NIVEAU ETUDE=============================

    //=============================GESTION UE=============================
    public function gestionUe()
    {
        $ue_a_modifier = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_ue'])) {
            $lib_ue = $_POST['ue'];

            if (!empty($_POST['id_ue'])) {
                // MODIFICATION
                $this->ue->updateUe($_POST['id_ue'], $lib_ue);
            } else {
                // AJOUT
                $this->ue->ajouterUe($lib_ue);
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            foreach ($_POST['selected_ids'] as $id) {
                $this->ue->deleteUe($id);
            }
        }
        // Récupération de l'UE à modifier pour affichage dans le formulaire
        if (isset($_GET['id_ue'])) {
            $ue_a_modifier = $this->ue->getUeById($_GET['id_ue']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['ue_a_modifier'] = $ue_a_modifier;
        $GLOBALS['listeUes'] = $this->ue->getAllUes();
    }
    //=============================FIN GESTION UE=============================
*/
}
/*Ce fichier est le contrôleur principal pour la gestion des paramètres généraux de l'application.
    Il gère les actions liées aux entités telles que les années académiques, les grades, les ECUE, etc.
    Chaque méthode correspond à une fonctionnalité spécifique et interagit avec le modèle approprié. */