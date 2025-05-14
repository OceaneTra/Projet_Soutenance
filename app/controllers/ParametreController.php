<?php
require_once __DIR__ . '/../config/DbModel.class.php';
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
        $this->anneeAcademique = new AnneeAcademique();
        $this->action = new Action();
        $this->fonction = new Fonction();
        $this->grade = new Grade();
        $this->groupeUtilisateur = new GroupeUtilisateur();
        $this->niveauAccesDonnees = new NiveauAccesDonnees();
        $this->niveauApprobation = new NiveauApprobation();
        $this->typeUtilisateur = new TypeUtilisateur();
        $this->ue = new Ue();
        $this->ecue = new Ecue();
        $this->statutJury = new StatutJury();
        $this->specialite = new Specialite();
        $this->niveauEtude = new NiveauEtude();
        $this->semestre = new Semestre();
    }


    //=============================GESTION ANNEE ACADEMIQUE=============================
    public function gestionAnnees(): void
    {
        $annee_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        // Traitement du formulaire d'ajout/modification
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['btn_add_annees_academiques'])) {
                // Validation des données
                if (empty($_POST['date_deb']) || empty($_POST['date_fin'])) {
                    $messageErreur = "Les dates sont obligatoires";
                } else {
                    $dateDebut = $_POST['date_deb'];
                    $dateFin = $_POST['date_fin'];

                    if ($dateDebut >= $dateFin) {
                        $messageErreur = "Erreur : la date de début ne peut pas être postérieure à la date de fin";
                    } else {
                        try {
                            if (!empty($_POST['id_annee_acad'])) {
                                // MODIFICATION
                                $success = $this->anneeAcademique->updateAnneeAcademique(
                                    (int) $_POST['id_annee_acad'],
                                    $dateDebut,
                                    $dateFin
                                );

                                if ($success) {
                                    $messageSucces = "Année académique modifiée avec succès";
                                } else {
                                    $messageErreur = "Erreur lors de la modification de l'année académique";
                                }
                            } else {
                                // AJOUT
                                $success = $this->anneeAcademique->ajouterAnneeAcademique($dateDebut, $dateFin);

                                if ($success) {
                                    $messageSucces = "Année académique ajoutée avec succès";


                                } else {
                                    $messageErreur = "Erreur lors de l'ajout de l'année académique";
                                }
                            }
                        } catch (Exception $e) {
                            $messageErreur = "Une erreur technique est survenue : " . $e->getMessage();
                        }
                    }
                }
            }

            // Traitement de la suppression
            if (isset($_POST['submit_delete_multiple']) && !empty($_POST['selected_ids'])) {
                try {
                    $success = true;
                    foreach ($_POST['selected_ids'] as $id) {
                        if (!$this->anneeAcademique->deleteAnneeAcademique((int) $id)) {
                            $success = false;
                        }
                    }

                    if ($success) {
                        $messageSucces = "Suppression des années académiques effectuée avec succès";


                    } else {
                        $messageErreur = "Erreur lors de la suppression d'une ou plusieurs années académiques";
                    }
                } catch (Exception $e) {
                    $messageErreur = "Une erreur technique est survenue lors de la suppression : " . $e->getMessage();
                }
            }
        }

        // Récupération de l'année à modifier
        if (isset($_GET['id_annee_acad'])) {
            $annee_a_modifier = $this->anneeAcademique->getAnneeAcademiqueById((int) $_GET['id_annee_acad']);
        }

        // Récupération de toutes les années académiques
        $listeAnnees = $this->anneeAcademique->getAllAnneeAcademiques();

        // Variables disponibles pour la vue
        $GLOBALS['annee_a_modifier'] = $annee_a_modifier;
        $GLOBALS['listeAnnees'] = $listeAnnees;
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION ANNEE ACADEMIQUE=============================


    //=============================GESTION GRADES=============================
    public function gestionGrade(): void
    {

        $grades_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_grades'])) {
            $lib_grade = $_POST['grades'];

            if (!empty($_POST['id_grade'])) {
                // MODIFICATION
                if ($this->grade->updateGrade($_POST['id_grade'], $lib_grade)) {
                    $messageSucces = "Grade modifié avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification du grade";
                }
            } else {
                // AJOUT
                if ($this->grade->ajouterGrade($lib_grade)) {
                    $messageSucces = "Grade ajouté avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du grade";
                }
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->grade->deleteGrade($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des grades effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'un ou plusieurs grades";
            }
        }

        // Récupération du grade à modifier pour affichage dans le formulaire
        if (isset($_GET['id_grade'])) {
            $grades_a_modifier = $this->grade->getGradeById($_GET['id_grade']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['grade_a_modifier'] = $grades_a_modifier;
        $GLOBALS['listeGrade'] = $this->grade->getAllGrades();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION GRADES=============================


    //=============================GESTION FONCTION UTILISATEUR=============================
    public function gestionFonctionUtilisateur(): void
    {
        $groupe_a_modifier = null;
        $type_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        //======PARTIE GROUPE UTILISATEUR======

        //Ajout ou modification
        if (isset($_GET['tab']) && $_GET['tab'] === 'groupes') {
            //Ajout ou modif
            if (isset($_POST['submit_add_groupe'])) {
                $lib_groupe = $_POST['lib_groupe'];

                if (!empty($_POST['id_groupe'])) {
                    //MODIF
                    if ($this->groupeUtilisateur->updateGroupeUtilisateur($_POST['id_groupe'], $lib_groupe)) {
                        $messageSucces = "Groupe utilisateur modifié avec succès";
                    } else {
                        $messageErreur = "Erreur lors de la modification du groupe utilisateur";
                    }
                } else {
                    //AJOUT
                    if ($this->groupeUtilisateur->ajouterGroupeUtilisateur($lib_groupe)) {
                        $messageSucces = "Groupe utilisateur ajouté avec succès";
                    } else {
                        $messageErreur = "Erreur lors de l'ajout du groupe utilisateur";
                    }
                }
            }

            // Suppression multiple
            if (isset($_POST['submit_delete_multiple_groupe']) && isset($_POST['selected_ids'])) {
                $success = true;
                foreach ($_POST['selected_ids'] as $id) {
                    if (!$this->groupeUtilisateur->deleteGroupeUtilisateur($id)) {
                        $success = false;
                    }
                }
                if ($success) {
                    $messageSucces = "Suppression des groupes utilisateurs effectuée avec succès";
                } else {
                    $messageErreur = "Erreur lors de la suppression d'un ou plusieurs groupes utilisateurs";
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
        if (isset($_GET['tab']) && isset($_GET['tab']) == 'types') {
            //Ajout ou modif
            if (isset($_POST['submit_add_type'])) {
                $lib_type_utilisateur = $_POST['lib_type_utilisateur'];
                if (!empty($_POST['id_type_utilisateur'])) {
                    //MODIF
                    if ($this->typeUtilisateur->updateTypeUtilisateur($_POST['id_type_utilisateur'], $lib_type_utilisateur)) {
                        $messageSucces = "Type utilisateur modifié avec succès";
                    } else {
                        $messageErreur = "Erreur lors de la modification du type utilisateur";
                    }
                } else {
                    //AJOUT
                    if ($this->typeUtilisateur->ajouterTypeUtilisateur($lib_type_utilisateur)) {
                        $messageSucces = "Type utilisateur ajouté avec succès";
                    } else {
                        $messageErreur = "Erreur lors de l'ajout du type utilisateur";
                    }
                }
            }

            // Suppression multiple
            if (isset($_POST['submit_delete_multiple_type']) && isset($_POST['selected_ids'])) {
                $success = true;
                foreach ($_POST['selected_ids'] as $id) {
                    if (!$this->typeUtilisateur->deleteTypeUtilisateur($id)) {
                        $success = false;
                    }
                }
                if ($success) {
                    $messageSucces = "Suppression des types utilisateurs effectuée avec succès";
                } else {
                    $messageErreur = "Erreur lors de la suppression d'un ou plusieurs types utilisateurs";
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

        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION FONCTION UTILISATEUR=============================


    //=============================GESTION SPECIALITE=============================
    public function gestionSpecialite(): void
    {
        $specialite_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_specialite'])) {
            $lib_specialite = $_POST['specialite'];

            if (!empty($_POST['id_specialite'])) {
                // MODIFICATION
                if ($this->specialite->updateSpecialite($_POST['id_specialite'], $lib_specialite)) {
                    $messageSucces = "Spécialité modifiée avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification de la spécialité";
                }
            } else {
                // AJOUT
                if ($this->specialite->ajouterSpecialite($lib_specialite)) {
                    $messageSucces = "Spécialité ajoutée avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de la spécialité";
                }
            }
        }
        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->specialite->deleteSpecialite($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des spécialités effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'une ou plusieurs spécialités";
            }
        }

        // Récupération de la spécialité à modifier pour affichage dans le formulaire
        if (isset($_GET['id_specialite'])) {
            $specialite_a_modifier = $this->specialite->getSpecialiteById($_GET['id_specialite']);
        }
        // 📦 Variables disponibles pour la vue
        $GLOBALS['specialite_a_modifier'] = $specialite_a_modifier;
        $GLOBALS['listeSpecialites'] = $this->specialite->getAllSpecialites();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION SPECIALITE=============================


    //=============================GESTION NIVEAU ETUDE=============================
    public function gestionNiveauEtude()
    {
        $niveau_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        if (isset($_POST['btn_add_niveau_etude'])) {
            $lib_niveau = $_POST['niveau_etude'];

            if (!empty($_POST['id_niveau_etude'])) {
                if ($this->niveauEtude->updateNiveauEtude($_POST['id_niveau_etude'], $lib_niveau)) {
                    $messageSucces = "Niveau d'étude modifié avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification du niveau d'étude";
                }
            } else {
                if ($this->niveauEtude->ajouterNiveauEtude($lib_niveau)) {
                    $messageSucces = "Niveau d'étude ajouté avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du niveau d'étude";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->niveauEtude->deleteNiveauEtude($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des niveaux d'étude effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'un ou plusieurs niveaux d'étude";
            }
        }

        if (isset($_GET['id_niveau_etude'])) {
            $niveau_a_modifier = $this->niveauEtude->getNiveauEtudeById($_GET['id_niveau_etude']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauEtude->getAllNiveauxEtudes();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION NIVEAU ETUDE=============================


    //=============================GESTION UE=============================
    public function gestionUe()
    {
        $ue_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        if (isset($_POST['submit_add_ue'])) {
            $lib_ue = $_POST['lib_ue'];
            $credit = $_POST['credits'];
            $id_niveau_etude = $_POST['niveau'];
            $id_semestre = $_POST['semestre'];
            $id_annee = $_POST['annee_academiques'];

            if (!empty($_POST['id_ue'])) {
                if ($this->ue->updateUe($_POST['id_ue'], $lib_ue, $id_niveau_etude, $id_semestre, $id_annee, $credit)) {
                    $messageSucces = "UE modifiée avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'UE";
                }
            } else {
                if ($this->ue->ajouterUe($lib_ue, $id_niveau_etude, $id_semestre, $id_annee, $credit)) {
                    $messageSucces = "UE ajoutée avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'UE";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->ue->deleteUe($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des UEs effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'une ou plusieurs UEs";
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
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION UE=============================


    //=============================GESTION ECUE=============================
    public function gestionEcue(): void
    {
        $ecue_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        // Ajout ou modification
        if (isset($_POST['submit_add_ecue'])) {
            $id_ue = $_POST['ue'];
            $lib_ecue = $_POST['lib_ecue'];
            $credit = $_POST['credits'];

            if (!empty($_POST['id_ecue'])) {
                $result = $this->ecue->updateEcue($_POST['id_ecue'], $id_ue, $lib_ecue, $credit);
                if ($result) {
                    $messageSucces = "ECUE modifiée avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'ECUE";
                }
            } else {
                $result = $this->ecue->ajouterEcue($id_ue, $lib_ecue, $credit);
                if ($result) {
                    $messageSucces = "ECUE ajoutée avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'ECUE";
                }
            }

            if (!$result) {
                $GLOBALS['error_credit'] = "Le total des crédits ECUE dépasserait celui de l'UE.";
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->ecue->deleteEcue($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des ECUEs effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'une ou plusieurs ECUEs";
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
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION ECUE=============================


    //=============================GESTION STATUT JURY=============================
    public function gestionStatutJury()
    {
        $statut_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        if (isset($_POST['btn_add_statut_jury'])) {
            $lib_statut = $_POST['statut_jury'];

            if (!empty($_POST['id_statut_jury'])) {
                if ($this->statutJury->updateStatutJury($_POST['id_statut_jury'], $lib_statut)) {
                    $messageSucces = "Statut jury modifié avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification du statut jury";
                }
            } else {
                if ($this->statutJury->ajouterStatutJury($lib_statut)) {
                    $messageSucces = "Statut jury ajouté avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du statut jury";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->statutJury->deleteStatutJury($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des statuts jury effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'un ou plusieurs statuts jury";
            }
        }

        if (isset($_GET['id_statut_jury'])) {
            $statut_a_modifier = $this->statutJury->getStatutJuryById($_GET['id_statut_jury']);
        }

        $GLOBALS['statut_a_modifier'] = $statut_a_modifier;
        $GLOBALS['listeStatuts'] = $this->statutJury->getAllStatutsJury();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION STATUT JURY=============================


    //=============================GESTION NIVEAU APPROBATION=============================
    public function gestionNiveauApprobation(): void
    {
        $niveau_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        if (isset($_POST['btn_add_niveau_approbation'])) {
            $lib_niveau = $_POST['niveaux_approbation'];

            if (!empty($_POST['id_niveau_approbation'])) {
                $this->niveauApprobation->updateNiveauApprobation($_POST['id_niveau_approbation'], $lib_niveau);
            } else {
                if ($this->niveauApprobation->ajouterNiveauApprobation($lib_niveau)) {
                    $messageSucces = "Niveau d'approbation ajouté avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du niveau d'approbation";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->niveauApprobation->deleteNiveauApprobation($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des niveaux d'approbation effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'un ou plusieurs niveaux d'approbation";
            }
        }

        if (isset($_GET['id_approb'])) {
            $niveau_a_modifier = $this->niveauApprobation->getNiveauApprobationById($_GET['id_approb']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauApprobation->getAllNiveauxApprobation();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION NIVEAU APPROBATION=============================


    //=============================GESTION SEMESTRES=============================
    public function gestionSemestre()
    {
        $semestre_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        if (isset($_POST['btn_add_semestres'])) {
            $lib_semestre = $_POST['semestres'];

            if (!empty($_POST['id_semestre'])) {
                if ($this->semestre->updateSemestre($_POST['id_semestre'], $lib_semestre)) {
                    $messageSucces = "Semestre modifié avec succès";
                } else {
                    $messageErreur = "Erreur lors de la modification du semestre";
                }
            } else {
                if ($this->semestre->ajouterSemestre($lib_semestre)) {
                    $messageSucces = "Semestre ajouté avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du semestre";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->semestre->deleteSemestre($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des semestres effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'un ou plusieurs semestres";
            }
        }

        if (isset($_GET['id_semestre'])) {
            $semestre_a_modifier = $this->semestre->getSemestreById($_GET['id_semestre']);
        }

        $GLOBALS['semestre_a_modifier'] = $semestre_a_modifier;
        $GLOBALS['listeSemestres'] = $this->semestre->getAllSemestres();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION SEMESTRES=============================








    //=============================GESTION NIVEAU ACCES DONNEES=============================
    public function gestionNiveauAccesDonnees()
    {
        $niveau_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        if (isset($_POST['btn_add_niveau_acces_donnees'])) {
            $lib_niveau = $_POST['niveau_acces_donnees'];

            if (!empty($_POST['id_niveau_acces_donnees'])) {
                $this->niveauAccesDonnees->updateNiveauAcces($_POST['id_niveau_acces_donnees'], $lib_niveau);
            } else {
                if ($this->niveauAccesDonnees->ajouterNiveauAcces($lib_niveau)) {
                    $messageSucces = "Niveau d'accès aux données ajouté avec succès";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du niveau d'accès aux données";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->niveauAccesDonnees->deleteNiveauAcces($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des niveaux d'accès effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'un ou plusieurs niveaux d'accès";
            }
        }

        if (isset($_GET['id_niveau_acces_donnees'])) {
            $niveau_a_modifier = $this->niveauAccesDonnees->getNiveauAccesById($_GET['id_niveau_acces_donnees']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauAccesDonnees->getAllNiveauxAcces();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSucces'] = $messageSucces;
    }
    //=============================FIN GESTION NIVEAU ACCES DONNEES=============================



    //=============================GESTION FONCTION=============================
    public function gestionFonction()
    {
        $fonction_a_modifier = null;
        $messageErreur = null;
        $messageSucces = null;

        // Ajout ou modification
        if (isset($_POST['btn_add_fonction'])) {
            $lib_fonction = $_POST['fonction'];

            if (!empty($_POST['id_fonction'])) {
                $this->fonction->updateFonction($_POST['id_fonction'], $lib_fonction);
            } else {
                $this->fonction->addFonction($lib_fonction);
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if (!$this->fonction->deleteFonction($id)) {
                    $success = false;
                }
            }
            if ($success) {
                $messageSucces = "Suppression des fonctions effectuée avec succès";
            } else {
                $messageErreur = "Erreur lors de la suppression d'une ou plusieurs fonctions";
            }
        }

        // Récupération de la fonction à modifier pour affichage dans le formulaire
        if (isset($_GET['id_fonction'])) {
            $fonction_a_modifier = $this->fonction->getFonctionById($_GET['id_fonction']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['fonction_a_modifier'] = $fonction_a_modifier;
        $GLOBALS['listeFonctions'] = $this->fonction->getAllFonctions();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageError'] = $messageSucces;
    }

    //=============================FIN GESTION FONCTION=============================

 //=============================GESTION MESSAGE=============================
 public function gestionMessage()
 {
     $message_a_modifier = null;
     $messageErreur = null;
     $messageSucces = null;

     // Ajout ou modification
     if (isset($_POST['btn_add_message'])) {
         $lib_message = $_POST['message'];

         if (!empty($_POST['id_message'])) {
             $this->message->updateMessage($_POST['id_message'], $lib_message);
         } else {
             $this->message->addMessage($lib_message);
         }
     }

     // Suppression multiple
     if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
         $success = true;
         foreach ($_POST['selected_ids'] as $id) {
             if (!$this->message->deleteMessage($id)) {
                 $success = false;
             }
         }
         if ($success) {
             $messageSucces = "Suppression des messages effectuée avec succès";
         } else {
             $messageErreur = "Erreur lors de la suppression d'une ou plusieurs messages";
         }
     }

     // Récupération du message à modifier pour affichage dans le formulaire
     if (isset($_GET['id_message'])) {
         $message_a_modifier = $this->message->getMessageById($_GET['id_message']);
     }

     // 📦 Variables disponibles pour la vue
     $GLOBALS['message_a_modifier'] = $message_a_modifier;
     $GLOBALS['listeMessages'] = $this->message->getAllMessages();
     $GLOBALS['messageErreur'] = $messageErreur;
     $GLOBALS['messageSucces'] = $messageSucces;

 }

 //=============================FIN GESTION MESSAGE=============================

  //=============================GESTION TRAITEMENT=============================
  public function gestionTraitement()
  {
      $traitement_a_modifier = null;
      $messageErreur = null;
      $messageSucces = null;
 
      // Ajout ou modification
      if (isset($_POST['btn_add_traitement'])) {
          $lib_traitement= $_POST['traitement'];
 
          if (!empty($_POST['id_traitement'])) {
              $this->traitement->updateTraitement($_POST['id_traitement'], $lib_traitement);
          } else {
              $this->traitement->addTraitement($lib_traitement);
          }
      }
 
      // Suppression multiple
      if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
          $success = true;
          foreach ($_POST['selected_ids'] as $id) {
              if (!$this->traitement->deleteTraitement($id)) {
                  $success = false;
              }
          }
          if ($success) {
              $messageSucces = "Suppression des traitements effectuée avec succès";
          } else {
              $messageErreur = "Erreur lors de la suppression d'une ou plusieurs traitements";
          }
      }
 
      // Récupération du traitement à modifier pour affichage dans le formulaire
      if (isset($_GET['id_traitement'])) {
          $traitement_a_modifier = $this->traitement->getTraitementById($_GET['id_traitement']);
      }
 
      // 📦 Variables disponibles pour la vue
      $GLOBALS['traitement_a_modifier'] = $traitement_a_modifier;
      $GLOBALS['listeTraitements'] = $this->traitement->getAllTraitements();
      $GLOBALS['messageErreur'] = $messageErreur;
      $GLOBALS['messageSucces'] = $messageSucces;
 
  }
 
  //=============================FIN GESTION TRAITEMENT=============================

   //=============================GESTION ENTREPRISE=============================
 public function gestionEntreprise()
 {
     $entreprise_a_modifier = null;
     $messageErreur = null;
     $messageSucces = null;

     // Ajout ou modification
     if (isset($_POST['btn_add_entreprise'])) {
         $lib_entreprise = $_POST['entreprise'];

         if (!empty($_POST['id_entreprise'])) {
             $this->entreprise->updateEntreprise($_POST['id_entreprise'], $lib_entreprise);
         } else {
             $this->entreprise->addEntreprise($lib_entreprise);
         }
     }

     // Suppression multiple
     if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
         $success = true;
         foreach ($_POST['selected_ids'] as $id) {
             if (!$this->entreprise->deleteEntreprise($id)) {
                 $success = false;
             }
         }
         if ($success) {
             $messageSucces = "Suppression des entreprises effectuée avec succès";
         } else {
             $messageErreur = "Erreur lors de la suppression d'une ou plusieurs entreprises";
         }
     }

     // Récupération de l'entreprise à modifier pour affichage dans le formulaire
     if (isset($_GET['id_entreprise'])) {
         $entreprise_a_modifier = $this->entreprise->getEntrepriseById($_GET['id_entreprise']);
     }

     // 📦 Variables disponibles pour la vue
     $GLOBALS['entreprise_a_modifier'] = $entreprise_a_modifier;
     $GLOBALS['listeEntreprises'] = $this->entreprise->getAllEntreprises();
     $GLOBALS['messageErreur'] = $messageErreur;
     $GLOBALS['messageSucces'] = $messageSucces;

 }

 //=============================FIN GESTION ENTREPRISE=============================

//=============================GESTION ACTION=============================
  public function gestionAction()
  {
      $action_a_modifier = null;
      $messageErreur = null;
      $messageSucces = null;
 
      // Ajout ou modification
      if (isset($_POST['btn_add_action'])) {
          $lib_action = $_POST['action'];
 
          if (!empty($_POST['id_action'])) {
              $this->action->updateAction($_POST['id_action'], $lib_action);
          } else {
              $this->action->addAction($lib_action);
          }
      }
 
      // Suppression multiple
      if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
          $success = true;
          foreach ($_POST['selected_ids'] as $id) {
              if (!$this->action->deleteAction($id)) {
                  $success = false;
              }
          }
          if ($success) {
              $messageSucces = "Suppression des actions effectuée avec succès";
          } else {
              $messageErreur = "Erreur lors de la suppression d'une ou plusieurs actions";
          }
      }
 
      // Récupération de l'action à modifier pour affichage dans le formulaire
      if (isset($_GET['id_action'])) {
          $action_a_modifier = $this->action->getActionById($_GET['id_action']);
      }
 
      // 📦 Variables disponibles pour la vue
      $GLOBALS['action_a_modifier'] = $action_a_modifier;
      $GLOBALS['listeActions'] = $this->action->getAllAction();
      $GLOBALS['messageErreur'] = $messageErreur;
      $GLOBALS['messageSucces'] = $messageSucces;
 
  }
 }
  //=============================FIN GESTION ACTIONS=============================

  


/*Ce fichier est le contrôleur principal pour la gestion des paramètres généraux de l'application.
    Il gère les actions liées aux entités telles que les années académiques, les grades, les ECUE, etc.
    Chaque méthode correspond à une fonctionnalité spécifique et interagit avec le modèle approprié. */