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
        $messageErreur = '';
        $messageSuccess = '';

        // Ajout ou modification
        if (isset($_POST['btn_add_annees_academiques']) || isset($_POST['btn_modifier_annees_academiques'])) {
            $dateDebut = $_POST['date_debut'];
            $dateFin = $_POST['date_fin'];
            $annee1 = date("Y", strtotime($dateDebut));
            $annee2 = date("Y", strtotime($dateFin));
            // Calculer le nouvel ID basé sur les nouvelles dates
            $nouvel_id = substr($annee2, 0, 1) . substr($annee2, 2, 2) . substr($annee1, 2, 2);  
             if (($annee1 == $annee2) || ($dateDebut >= $dateFin)) {
                    $messageErreur = "Les dates de début et de fin ne sont pas valides.";
                } 
            if ($this->anneeAcademique->isAnneeAcademiqueExist($nouvel_id, $dateDebut, $dateFin)) {
                        $messageErreur = "Cette année académique existe déjà.";
                    }
        // Vérification de l'existence de l'année académique
                if ($this->anneeAcademique->isAnneeAcademiqueInUse($nouvel_id)) {
                    $messageErreur = "Cette année académique est déjà utilisée.";
                }
            if (!empty($_POST['id_annee_acad'])) {
                
                // Calculer le nouvel ID basé sur les nouvelles dates
                $nouvel_id = substr($annee2, 0, 1) . substr($annee2, 2, 2) . substr($annee1, 2, 2);     
                // MODIFICATION
               if($this->anneeAcademique->updateAnneeAcademique($nouvel_id, $dateDebut, $dateFin)){
                    $messageSuccess = "Année académique modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la mise à jour de l'année académique.";
                }
            } else {
                // AJOUT
                if ($this->anneeAcademique->ajouterAnneeAcademique($dateDebut, $dateFin)){
                    $messageSuccess = "Année académique ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'année académique.";
                }
               
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && $_POST['submit_delete_multiple'] == '1' && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->anneeAcademique->deleteAnneeAcademique($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Années académiques supprimées avec succès.";
            } else {
               $messageErreur = "Erreur lors de la suppression des années académiques.";
            }
        }

        // Récupération de l'année à modifier pour affichage dans le formulaire
        if (isset($_GET['id_annee_acad'])) {
            $annee_a_modifier = $this->anneeAcademique->getAnneeAcademiqueById($_GET['id_annee_acad']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['annee_a_modifier'] = $annee_a_modifier;
        $GLOBALS['listeAnnees'] = $this->anneeAcademique->getAllAnneeAcademiques();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION ANNEE ACADEMIQUE=============================


    //=============================GESTION GRADES=============================
    public function gestionGrade()
    {
        $grades_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        // Ajout ou modification
        if (isset($_POST['btn_add_grades']) || isset($_POST['btn_modifier_grades'])) {
            $lib_grade = $_POST['grades'];

            if (!empty($_POST['id_grade'])) {
                // MODIFICATION
                if($this->grade->updateGrade($_POST['id_grade'], $lib_grade)) {
                    $messageSuccess = "Grade modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du grade.";
                }
            } else {
                // AJOUT
                if($this->grade->ajouterGrade($lib_grade)) {
                    $messageSuccess = "Grade ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du grade.";
                }
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->grade->deleteGrade($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Grades supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des grades.";
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
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION GRADES=============================




    //=============================GESTION FONCTION UTILISATEUR=============================
    public function gestionFonctionUtilisateur()
    {
        $groupe_a_modifier = null;
        $type_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        //======PARTIE GROUPE UTILISATEUR======
        if (isset($_GET['tab']) && $_GET['tab'] === 'groupes') {
            if (isset($_POST['submit_add_groupe'])) {
                $lib_groupe = $_POST['lib_groupe'];

                if (!empty($_POST['id_groupe'])) {
                    if($this->groupeUtilisateur->updateGroupeUtilisateur($_POST['id_groupe'], $lib_groupe)) {
                        $messageSuccess = "Groupe utilisateur modifié avec succès.";
                    } else {
                        $messageErreur = "Erreur lors de la modification du groupe utilisateur.";
                    }
                } else {
                    if($this->groupeUtilisateur->ajouterGroupeUtilisateur($lib_groupe)) {
                        $messageSuccess = "Groupe utilisateur ajouté avec succès.";
                    } else {
                        $messageErreur = "Erreur lors de l'ajout du groupe utilisateur.";
                    }
                }
            }

            // Suppression multiple
            if (isset($_POST['submit_delete_multiple_groupe']) && isset($_POST['selected_ids'])) {
                $success = true;
                foreach ($_POST['selected_ids'] as $id) {
                    if(!$this->groupeUtilisateur->deleteGroupeUtilisateur($id)) {
                        $success = false;
                        break;
                    }
                }
                
                if ($success) {
                    $messageSuccess = "Groupes utilisateurs supprimés avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la suppression des groupes utilisateurs.";
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
            if (isset($_POST['submit_add_type'])) {
                $lib_type_utilisateur = $_POST['lib_type_utilisateur'];
                if (!empty($_POST['id_type_utilisateur'])) {
                    if($this->typeUtilisateur->updateTypeUtilisateur($_POST['id_type_utilisateur'], $lib_type_utilisateur)) {
                        $messageSuccess = "Type utilisateur modifié avec succès.";
                    } else {
                        $messageErreur = "Erreur lors de la modification du type utilisateur.";
                    }
                } else {
                    if($this->typeUtilisateur->ajouterTypeUtilisateur($lib_type_utilisateur)) {
                        $messageSuccess = "Type utilisateur ajouté avec succès.";
                    } else {
                        $messageErreur = "Erreur lors de l'ajout du type utilisateur.";
                    }
                }
            }

            // Suppression multiple
            if (isset($_POST['submit_delete_multiple_type']) && isset($_POST['selected_ids'])) {
                $success = true;
                foreach ($_POST['selected_ids'] as $id) {
                    if(!$this->typeUtilisateur->deleteTypeUtilisateur($id)) {
                        $success = false;
                        break;
                    }
                }
                
                if ($success) {
                    $messageSuccess = "Types utilisateurs supprimés avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la suppression des types utilisateurs.";
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

        // 📦 Variables disponibles pour la vue
        $GLOBALS['groupe_a_modifier'] = $groupe_a_modifier;
        $GLOBALS['type_a_modifier'] = $type_a_modifier;
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION FONCTION UTILISATEUR=============================


//=============================GESTION SPECIALITE=============================
    public function gestionSpecialite()
    {
        $specialite_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        // Ajout ou modification
        if (isset($_POST['btn_add_specialite'])|| isset($_POST['btn_modifier_specialite'])) {
            $lib_specialite = $_POST['specialite'];

            if (!empty($_POST['id_specialite'])) {
                if($this->specialite->updateSpecialite($_POST['id_specialite'], $lib_specialite)) {
                    $messageSuccess = "Spécialité modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de la spécialité.";
                }
            } else {
                if($this->specialite->ajouterSpecialite($lib_specialite)) {
                    $messageSuccess = "Spécialité ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de la spécialité.";
                }
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->specialite->deleteSpecialite($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Spécialités supprimées avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des spécialités.";
            }
        }

        // Récupération de la spécialité à modifier
        if (isset($_GET['id_specialite'])) {
            $specialite_a_modifier = $this->specialite->getSpecialiteById($_GET['id_specialite']);
        }

        // 📦 Variables disponibles pour la vue
        $GLOBALS['specialite_a_modifier'] = $specialite_a_modifier;
        $GLOBALS['listeSpecialites'] = $this->specialite->getAllSpecialites();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION SPECIALITE=============================


    //=============================GESTION NIVEAU ETUDE=============================
    public function gestionNiveauEtude()
    {
        $niveau_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_niveau_etude']) || isset($_POST['btn_modifier_niveau_etude'])) {
            $lib_niveau = $_POST['lib_niv_etude'];

            if (!empty($_POST['id_niv_etude'])) {
                if($this->niveauEtude->updateNiveauEtude($_POST['id_niv_etude'], $lib_niveau)) {
                    $messageSuccess = "Niveau d'étude modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du niveau d'étude.";
                }
            } else {
                if($this->niveauEtude->ajouterNiveauEtude($lib_niveau)) {
                    $messageSuccess = "Niveau d'étude ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du niveau d'étude.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->niveauEtude->deleteNiveauEtude($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Niveaux d'étude supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des niveaux d'étude.";
            }
        }

        if (isset($_GET['id_niv_etude'])) {
            $niveau_a_modifier = $this->niveauEtude->getNiveauEtudeById($_GET['id_niv_etude']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauEtude->getAllNiveauxEtudes();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION NIVEAU ETUDE=============================


    //=============================GESTION UE=============================
    public function gestionUe()
    {
        $ue_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['submit_add_ue'])) {
            $lib_ue = $_POST['lib_ue'];
            $credit = $_POST['credits'];
            $id_niveau_etude = $_POST['niveau'];
            $id_semestre = $_POST['semestre'];
            $id_annee = $_POST['annee_academiques'];

            if (!empty($_POST['id_ue'])) {
                if($this->ue->updateUe($_POST['id_ue'], $lib_ue, $id_niveau_etude, $id_semestre, $id_annee, $credit)) {
                    $messageSuccess = "UE modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'UE.";
                }
            } else {
                if($this->ue->ajouterUe($lib_ue, $id_niveau_etude, $id_semestre, $id_annee, $credit)) {
                    $messageSuccess = "UE ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'UE.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->ue->deleteUe($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "UEs supprimées avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des UEs.";
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
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION UE=============================


    //=============================GESTION ECUE=============================
    public function gestionEcue()
    {
        $ecue_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['submit_add_ecue'])) {
            $id_ue = $_POST['ue'];
            $lib_ecue = $_POST['lib_ecue'];
            $credit = $_POST['credits'];

            if (!empty($_POST['id_ecue'])) {
                if($this->ecue->updateEcue($_POST['id_ecue'], $id_ue, $lib_ecue, $credit)) {
                    $messageSuccess = "ECUE modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'ECUE.";
                }
            } else {
                if($this->ecue->ajouterEcue($id_ue, $lib_ecue, $credit)) {
                    $messageSuccess = "ECUE ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'ECUE.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->ecue->deleteEcue($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "ECUEs supprimées avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des ECUEs.";
            }
        }

        if (isset($_GET['id_ecue'])) {
            $ecue_a_modifier = $this->ecue->getEcueById($_GET['id_ecue']);
        }

        $GLOBALS['ecue_a_modifier'] = $ecue_a_modifier;
        $GLOBALS['listeEcues'] = $this->ecue->getAllEcues();
        $GLOBALS['listeUes'] = $this->ue->getAllUes();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }

    //=============================FIN GESTION ECUE=============================


    //=============================GESTION STATUT JURY=============================
    public function gestionStatutJury()
    {
        $statut_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_statut_jury'])) {
            $lib_statut = $_POST['statut_jury'];

            if (!empty($_POST['id_statut_jury'])) {
                if($this->statutJury->updateStatutJury($_POST['id_statut_jury'], $lib_statut)) {
                    $messageSuccess = "Statut jury modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du statut jury.";
                }
            } else {
                if($this->statutJury->ajouterStatutJury($lib_statut)) {
                    $messageSuccess = "Statut jury ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du statut jury.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->statutJury->deleteStatutJury($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Statuts jury supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des statuts jury.";
            }
        }

        if (isset($_GET['id_statut_jury'])) {
            $statut_a_modifier = $this->statutJury->getStatutJuryById($_GET['id_statut_jury']);
        }

        $GLOBALS['statut_a_modifier'] = $statut_a_modifier;
        $GLOBALS['listeStatuts'] = $this->statutJury->getAllStatutsJury();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION STATUT JURY=============================


    //=============================GESTION NIVEAU APPROBATION=============================
    public function gestionNiveauApprobation()
    {
        $niveau_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_niveau_approbation']) || isset($_POST['btn_modifier_niveau_approbation'])) {
            $lib_niveau = $_POST['niveaux_approbation'];

            if (!empty($_POST['id_approb'])) {
                if($this->niveauApprobation->updateNiveauApprobation($_POST['id_approb'], $lib_niveau)) {
                    $messageSuccess = "Niveau d'approbation modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du niveau d'approbation.";
                }
            } else {
                if($this->niveauApprobation->ajouterNiveauApprobation($lib_niveau)) {
                    $messageSuccess = "Niveau d'approbation ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du niveau d'approbation.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->niveauApprobation->deleteNiveauApprobation($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Niveaux d'approbation supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des niveaux d'approbation.";
            }
        }

        if (isset($_GET['id_approb'])) {
            $niveau_a_modifier = $this->niveauApprobation->getNiveauApprobationById($_GET['id_approb']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauApprobation->getAllNiveauxApprobation();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION NIVEAU APPROBATION=============================


//=============================GESTION SEMESTRES=============================
    public function gestionSemestre()
    {
        $semestre_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_semestres'])) {
            $lib_semestre = $_POST['semestres'];

            if (!empty($_POST['id_semestre'])) {
                if($this->semestre->updateSemestre($_POST['id_semestre'], $lib_semestre)) {
                    $messageSuccess = "Semestre modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du semestre.";
                }
            } else {
                if($this->semestre->ajouterSemestre($lib_semestre)) {
                    $messageSuccess = "Semestre ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du semestre.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->semestre->deleteSemestre($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Semestres supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des semestres.";
            }
        }

        if (isset($_GET['id_semestre'])) {
            $semestre_a_modifier = $this->semestre->getSemestreById($_GET['id_semestre']);
        }

        $GLOBALS['semestre_a_modifier'] = $semestre_a_modifier;
        $GLOBALS['listeSemestres'] = $this->semestre->getAllSemestres();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION SEMESTRES=============================


//=============================GESTION NIVEAU ACCES DONNEES=============================
    public function gestionNiveauAccesDonnees()
    {
        $niveau_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_niveau_acces_donnees'])) {
            $lib_niveau = $_POST['niveau_acces_donnees'];

            if (!empty($_POST['id_niveau_acces'])) {
                if($this->niveauAccesDonnees->updateNiveauAccesDonnees($_POST['id_niveau_acces'], $lib_niveau)) {
                    $messageSuccess = "Niveau d'accès modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du niveau d'accès.";
                }
            } else {
                if($this->niveauAccesDonnees->ajouterNiveauAccesDonnees($lib_niveau)) {
                    $messageSuccess = "Niveau d'accès ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du niveau d'accès.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->niveauAccesDonnees->deleteNiveauAccesDonnees($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Niveaux d'accès supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des niveaux d'accès.";
            }
        }

        if (isset($_GET['id_niveau_acces'])) {
            $niveau_a_modifier = $this->niveauAccesDonnees->getNiveauAccesDonneesById($_GET['id_niveau_acces']);
        }

        $GLOBALS['niveau_a_modifier'] = $niveau_a_modifier;
        $GLOBALS['listeNiveaux'] = $this->niveauAccesDonnees->getAllNiveauxAccesDonnees();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
    //=============================FIN GESTION NIVEAU ACCES DONNEES=============================


    //=============================GESTION TRAITEMENT=============================
    public function gestionTraitement()
    {
        $traitement_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        // Ajout ou modification
        if (isset($_POST['btn_add_traitement'])) {
            $lib_traitement = $_POST['traitement'];

            if (!empty($_POST['id_traitement'])) {
                if($this->traitement->updateTraitement($_POST['id_traitement'], $lib_traitement)) {
                    $messageSuccess = "Traitement modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du traitement.";
                }
            } else {
                if($this->traitement->ajouterTraitement($lib_traitement)) {
                    $messageSuccess = "Traitement ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du traitement.";
                }
            }
        }

        // Suppression multiple
        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->traitement->deleteTraitement($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Traitements supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des traitements.";
            }
        }

        if (isset($_GET['id_traitement'])) {
            $traitement_a_modifier = $this->traitement->getTraitementById($_GET['id_traitement']);
        }

        $GLOBALS['traitement_a_modifier'] = $traitement_a_modifier;
        $GLOBALS['listeTraitements'] = $this->traitement->getAllTraitements();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION TRAITEMENT============================


    //=============================GESTION ENTREPRISE=============================
    public function gestionEntreprise()
    {
        $entreprise_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_entreprise']) || isset($_POST['btn_modifier_entreprise'])) {
            $lib_entreprise = $_POST['lib_entreprise'];

            if (!empty($_POST['id_entreprise'])) {
                if($this->entreprise->updateEntreprise($_POST['id_entreprise'], $lib_entreprise)) {
                    $messageSuccess = "Entreprise modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'entreprise.";
                }
            } else {
                if($this->entreprise->ajouterEntreprise($lib_entreprise)) {
                    $messageSuccess = "Entreprise ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'entreprise.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->entreprise->deleteEntreprise($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Entreprises supprimées avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des entreprises.";
            }
        }

        if (isset($_GET['id_entreprise'])) {
            $entreprise_a_modifier = $this->entreprise->getEntrepriseById($_GET['id_entreprise']);
        }

        $GLOBALS['entreprise_a_modifier'] = $entreprise_a_modifier;
        $GLOBALS['listeEntreprises'] = $this->entreprise->getAllEntreprises();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION ENTREPRISE============================

//=============================GESTION ACTION=============================
    public function gestionAction()
    {
        $action_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_action'])) {
            $lib_action = $_POST['action'];

            if (!empty($_POST['id_action'])) {
                if($this->action->updateAction($_POST['id_action'], $lib_action)) {
                    $messageSuccess = "Action modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de l'action.";
                }
            } else {
                if($this->action->ajouterAction($lib_action)) {
                    $messageSuccess = "Action ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de l'action.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->action->deleteAction($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Actions supprimées avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des actions.";
            }
        }

        if (isset($_GET['id_action'])) {
            $action_a_modifier = $this->action->getActionById($_GET['id_action']);
        }

        $GLOBALS['action_a_modifier'] = $action_a_modifier;
        $GLOBALS['listeActions'] = $this->action->getAllAction();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION ACTION============================

//=============================GESTION FONCTION=============================
    public function gestionFonction()
    {
        $fonction_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_fonction'])) {
            $lib_fonction = $_POST['fonction'];

            if (!empty($_POST['id_fonction'])) {
                if($this->fonction->updateFonction($_POST['id_fonction'], $lib_fonction)) {
                    $messageSuccess = "Fonction modifiée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification de la fonction.";
                }
            } else {
                if($this->fonction->ajouterFonction($lib_fonction)) {
                    $messageSuccess = "Fonction ajoutée avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout de la fonction.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->fonction->deleteFonction($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Fonctions supprimées avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des fonctions.";
            }
        }

        if (isset($_GET['id_fonction'])) {
            $fonction_a_modifier = $this->fonction->getFonctionById($_GET['id_fonction']);
        }

        $GLOBALS['fonction_a_modifier'] = $fonction_a_modifier;
        $GLOBALS['listeFonctions'] = $this->fonction->getAllFonction();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION FONCTION============================

//=============================GESTION MESSAGERIE=============================
    public function gestionMessagerie()
    {
        $message_a_modifier = null;
        $messageErreur = '';
        $messageSuccess = '';

        if (isset($_POST['btn_add_message'])) {
            $contenu_message = $_POST['message'];

            if (!empty($_POST['id_message'])) {
                if($this->message->updateMessage($_POST['id_message'], $contenu_message)) {
                    $messageSuccess = "Message modifié avec succès.";
                } else {
                    $messageErreur = "Erreur lors de la modification du message.";
                }
            } else {
                if($this->message->ajouterMessage($contenu_message)) {
                    $messageSuccess = "Message ajouté avec succès.";
                } else {
                    $messageErreur = "Erreur lors de l'ajout du message.";
                }
            }
        }

        if (isset($_POST['submit_delete_multiple']) && isset($_POST['selected_ids'])) {
            $success = true;
            foreach ($_POST['selected_ids'] as $id) {
                if(!$this->message->deleteMessage($id)) {
                    $success = false;
                    break;
                }
            }
            
            if ($success) {
                $messageSuccess = "Messages supprimés avec succès.";
            } else {
                $messageErreur = "Erreur lors de la suppression des messages.";
            }
        }

        if (isset($_GET['id_message'])) {
            $message_a_modifier = $this->message->getMessageById($_GET['id_message']);
        }

        $GLOBALS['message_a_modifier'] = $message_a_modifier;
        $GLOBALS['listeMessages'] = $this->message->getAllMessages();
        $GLOBALS['messageErreur'] = $messageErreur;
        $GLOBALS['messageSuccess'] = $messageSuccess;
    }
//=============================FIN GESTION MESSAGERIE============================


}
/*Ce fichier est le contrôleur principal pour la gestion des paramètres généraux de l'application.
    Il gère les actions liées aux entités telles que les années académiques, les grades, les ECUE, etc.
    Chaque méthode correspond à une fonctionnalité spécifique et interagit avec le modèle approprié. */