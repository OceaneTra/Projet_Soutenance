<?php
require_once __DIR__ . '/../models/AnneeAcademique.php';
require_once __DIR__ . '/../models/Grade.php';
require_once __DIR__ . '/../models/Fonction.php';
// Ajoutez ici les nouveaux modèles requis
// require_once __DIR__ . '/../models/Action.php';
// require_once __DIR__ . '/../models/ECUE.php';
// require_once __DIR__ . '/../models/UE.php';
// etc.

class ParametresController
{
    private $pdo;
    private $anneeAcademique;
    private $grade;
    private $fonction;
    // Initialiser les nouvelles propriétés pour les modèles
    // private $action;
    // private $ecue;
    // private $ue;
    // etc.

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->anneeAcademique = new AnneeAcademique($pdo);
        $this->grade = new Grade($pdo);
        $this->fonction = new Fonction($pdo);
        // Instancier les nouveaux modèles
        // $this->action = new Action($pdo);
        // $this->ecue = new ECUE($pdo);
        // $this->ue = new UE($pdo);
        // etc.
    }

    // Méthode pour afficher le dashboard des paramètres généraux
    public function index()
    {
        include __DIR__ . '/../../ressources/views/admin/dashboard.php';
    }

    // Méthode pour afficher la page principale des paramètres généraux
    public function afficherParametresGeneraux()
    {
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/vue_gparamgen.php';
    }

    // === GESTION DES ANNÉES ACADÉMIQUES ===

    // Méthodes existantes pour les années académiques
    public function anneeAcademique()
    {    $message = $_SESSION['success'] ?? '';
        $error = $_SESSION['error'] ?? '';

        // Vider les messages de session après les avoir récupérés
        unset($_SESSION['success'], $_SESSION['error']);

        // Récupérer toutes les années académiques
        $annees = $this->anneeAcademique->getAllAnneeAcademiques();


        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/annee_academique.php';;
    }

    public function ajouterAnnee()
    {
        // Code existant...
    }

    public function supprimerAnnee($id)
    {
        // Code existant...
    }

    // Nouvelles méthodes pour les années académiques
    public function listeAnneesAcademiques()
    {
        $annees = $this->anneeAcademique->getAllAnneeAcademiques();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/annees_academiques/liste.php';
    }

    public function ajouterAnneeAcademique()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateDebut = $_POST['date_deb'] ?? '';
            $dateFin = $_POST['date_fin'] ?? '';

            // Validation des données
            if (empty($dateDebut) || empty($dateFin)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                header('Location: /parametres/annees-academiques');
                exit;
            }

            $result = $this->anneeAcademique->addAnneeAcademique($dateDebut, $dateFin);

            if ($result) {
                $_SESSION['success'] = "Année académique ajoutée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout de l'année académique.";
            }

            header('Location: /parametres/annees-academiques');
            exit;
        }

        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/annees_academiques/ajouter.php';
    }

    public function modifierAnneeAcademique($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateDebut = $_POST['date_deb'] ?? '';
            $dateFin = $_POST['date_fin'] ?? '';

            // Validation des données
            if (empty($dateDebut) || empty($dateFin)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                header("Location: /parametres/annees-academiques/modifier/{$id}");
                exit;
            }

            $result = $this->anneeAcademique->updateAnneeAcademique($id, $dateDebut, $dateFin);

            if ($result) {
                $_SESSION['success'] = "Année académique modifiée avec succès.";
                header('Location: /parametres/annees-academiques');
            } else {
                $_SESSION['error'] = "Erreur lors de la modification de l'année académique.";
                header("Location: /parametres/annees-academiques/modifier/{$id}");
            }
            exit;
        }

        // Récupérer les données de l'année académique à modifier
        $annee = $this->anneeAcademique->getAnneeAcademiqueById($id);

        if (!$annee) {
            $_SESSION['error'] = "Année académique introuvable.";
            header('Location: /parametres/annees-academiques');
            exit;
        }

        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/annees_academiques/modifier.php';
    }

    public function supprimerAnneeAcademique($id)
    {
        if (!empty($id)) {
            // Vérifier si l'année est utilisée
            if ($this->anneeAcademique->isAnneeAcademiqueInUse($id)) {
                $_SESSION['error'] = "Impossible de supprimer cette année académique car elle est utilisée.";
                header('Location: /parametres/annees-academiques');
                exit;
            }

            $result = $this->anneeAcademique->deleteAnneeAcademique($id);

            if ($result) {
                $_SESSION['success'] = "Année académique supprimée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la suppression de l'année académique.";
            }
        }

        header('Location: /parametres/annees-academiques');
        exit;
    }

    public function activerAnneeAcademique($id)
    {
        if (!empty($id)) {
            // Désactiver toutes les années académiques
            $this->anneeAcademique->deactivateAllAnneeAcademiques();

            // Activer l'année spécifiée
            $result = $this->anneeAcademique->activateAnneeAcademique($id);

            if ($result) {
                $_SESSION['success'] = "Année académique activée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de l'activation de l'année académique.";
            }
        }

        header('Location: /parametres/annees-academiques');
        exit;
    }

    // === GESTION DES FONCTIONS ===

    // Méthodes existantes pour les fonctions
    public function fonction()
    {
        $fonctions = $this->fonction->getAllFonctions();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/fonction.php';
    }

    public function ajouterFonction()
    {
        // Code existant...
    }

    public function supprimerFonction($id)
    {
        // Code existant...
    }

    // Nouvelles méthodes pour les fonctions
    public function listeFonctions()
    {
        $fonctions = $this->fonction->getAllFonctions();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/fonctions/liste.php';
    }

    public function modifierFonction($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libelle = $_POST['lib_fonction'] ?? '';

            // Validation des données
            if (empty($libelle)) {
                $_SESSION['error'] = "Le libellé de la fonction est obligatoire.";
                header("Location: /parametres/fonctions/modifier/{$id}");
                exit;
            }

            $result = $this->fonction->updateFonction($id, $libelle);

            if ($result) {
                $_SESSION['success'] = "Fonction modifiée avec succès.";
                header('Location: /parametres/fonctions');
            } else {
                $_SESSION['error'] = "Erreur lors de la modification de la fonction.";
                header("Location: /parametres/fonctions/modifier/{$id}");
            }
            exit;
        }

        // Récupérer les données de la fonction à modifier
        $fonction = $this->fonction->getFonctionById($id);

        if (!$fonction) {
            $_SESSION['error'] = "Fonction introuvable.";
            header('Location: /parametres/fonctions');
            exit;
        }

        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/fonctions/modifier.php';
    }

    public function detailsFonction($id)
    {
        $fonction = $this->fonction->getFonctionById($id);

        if (!$fonction) {
            $_SESSION['error'] = "Fonction introuvable.";
            header('Location: /parametres/fonctions');
            exit;
        }

        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/fonctions/details.php';
    }

    // === GESTION DES GRADES ===

    // Méthodes existantes pour les grades
    public function grade()
    {
        $grades = $this->grade->getAllGrades();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/grade.php';
    }

    public function ajouterGrade()
    {
        // Code existant...
    }

    public function supprimerGrade($id)
    {
        // Code existant...
    }

    // Nouvelles méthodes pour les grades
    public function listeGrades()
    {
        $grades = $this->grade->getAllGrades();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/grades/liste.php';
    }

    public function modifierGrade($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libelle = $_POST['lib_grade'] ?? '';

            // Validation des données
            if (empty($libelle)) {
                $_SESSION['error'] = "Le libellé du grade est obligatoire.";
                header("Location: /parametres/grades/modifier/{$id}");
                exit;
            }

            $result = $this->grade->updateGrade($id, $libelle);

            if ($result) {
                $_SESSION['success'] = "Grade modifié avec succès.";
                header('Location: /parametres/grades');
            } else {
                $_SESSION['error'] = "Erreur lors de la modification du grade.";
                header("Location: /parametres/grades/modifier/{$id}");
            }
            exit;
        }

        // Récupérer les données du grade à modifier
        $grade = $this->grade->getGradeById($id);

        if (!$grade) {
            $_SESSION['error'] = "Grade introuvable.";
            header('Location: /parametres/grades');
            exit;
        }

        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/grades/modifier.php';
    }

    public function detailsGrade($id)
    {
        $grade = $this->grade->getGradeById($id);

        if (!$grade) {
            $_SESSION['error'] = "Grade introuvable.";
            header('Location: /parametres/grades');
            exit;
        }

        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/grades/details.php';
    }

    // === MÉTHODES POUR LES ACTIONS ===

    public function listeActions()
    {
        // À implémenter après avoir créé le modèle Action
        // $actions = $this->action->getAllActions();
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/actions/liste.php';
    }

    public function ajouterAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation après avoir créé le modèle Action
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/actions/ajouter.php';
    }

    public function modifierAction($id)
    {
        // À implémenter après avoir créé le modèle Action
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/actions/modifier.php';
    }

    public function supprimerAction($id)
    {
        // À implémenter après avoir créé le modèle Action
        header('Location: /parametres/actions');
        exit;
    }

    public function detailsAction($id)
    {
        // À implémenter après avoir créé le modèle Action
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/actions/details.php';
    }

    // === MÉTHODES POUR LES ECUE ===

    public function listeECUEs()
    {
        // À implémenter après avoir créé le modèle ECUE
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ecues/liste.php';
    }

    public function ajouterECUE()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation après avoir créé le modèle ECUE
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ecues/ajouter.php';
    }

    public function modifierECUE($id)
    {
        // À implémenter après avoir créé le modèle ECUE
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ecues/modifier.php';
    }

    public function supprimerECUE($id)
    {
        // À implémenter après avoir créé le modèle ECUE
        header('Location: /parametres/ecues');
        exit;
    }

    public function detailsECUE($id)
    {
        // À implémenter après avoir créé le modèle ECUE
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ecues/details.php';
    }

    // === MÉTHODES POUR LES UE ===

    public function listeUEs()
    {
        // À implémenter après avoir créé le modèle UE
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ues/liste.php';
    }

    public function ajouterUE()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation après avoir créé le modèle UE
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ues/ajouter.php';
    }

    public function modifierUE($id)
    {
        // À implémenter après avoir créé le modèle UE
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ues/modifier.php';
    }

    public function supprimerUE($id)
    {
        // À implémenter après avoir créé le modèle UE
        header('Location: /parametres/ues');
        exit;
    }

    public function detailsUE($id)
    {
        // À implémenter après avoir créé le modèle UE
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/ues/details.php';
    }

    // === MÉTHODES POUR LES GROUPES UTILISATEURS ===

    public function listeGroupesUtilisateurs()
    {
        // À implémenter après avoir créé le modèle GroupeUtilisateurs
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/groupes_utilisateurs/liste.php';
    }

    public function ajouterGroupeUtilisateurs()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation après avoir créé le modèle GroupeUtilisateurs
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/groupes_utilisateurs/ajouter.php';
    }

    public function modifierGroupeUtilisateurs($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/groupes_utilisateurs/modifier.php';
    }

    public function supprimerGroupeUtilisateurs($id)
    {
        // À implémenter
        header('Location: /parametres/groupes-utilisateurs');
        exit;
    }

    public function gererPermissionsGroupe($id)
    {
        // À implémenter - Gestion des permissions pour un groupe
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/groupes_utilisateurs/permissions.php';
    }

    // === MÉTHODES POUR LES NIVEAUX D'ACCÈS AUX DONNÉES ===

    public function listeNiveauxAccesDonnees()
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_acces_donnees/liste.php';
    }

    public function ajouterNiveauAccesDonnees()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_acces_donnees/ajouter.php';
    }

    public function modifierNiveauAccesDonnees($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_acces_donnees/modifier.php';
    }

    public function supprimerNiveauAccesDonnees($id)
    {
        // À implémenter
        header('Location: /parametres/niveaux-acces-donnees');
        exit;
    }

    // === MÉTHODES POUR LES NIVEAUX D'APPROBATION ===

    public function listeNiveauxApprobation()
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_approbation/liste.php';
    }

    public function ajouterNiveauApprobation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_approbation/ajouter.php';
    }

    public function modifierNiveauApprobation($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_approbation/modifier.php';
    }

    public function supprimerNiveauApprobation($id)
    {
        // À implémenter
        header('Location: /parametres/niveaux-approbation');
        exit;
    }

    // === MÉTHODES POUR LES NIVEAUX D'ÉTUDE ===

    public function listeNiveauxEtude()
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_etude/liste.php';
    }

    public function ajouterNiveauEtude()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_etude/ajouter.php';
    }

    public function modifierNiveauEtude($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/niveaux_etude/modifier.php';
    }

    public function supprimerNiveauEtude($id)
    {
        // À implémenter
        header('Location: /parametres/niveaux-etude');
        exit;
    }

    // === MÉTHODES POUR LES SPÉCIALITÉS ===

    public function listeSpecialites()
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/specialites/liste.php';
    }

    public function ajouterSpecialite()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/specialites/ajouter.php';
    }

    public function modifierSpecialite($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/specialites/modifier.php';
    }

    public function supprimerSpecialite($id)
    {
        // À implémenter
        header('Location: /parametres/specialites');
        exit;
    }

    // === MÉTHODES POUR LES STATUTS JURY ===

    public function listeStatutsJury()
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/statuts_jury/liste.php';
    }

    public function ajouterStatutJury()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/statuts_jury/ajouter.php';
    }

    public function modifierStatutJury($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/statuts_jury/modifier.php';
    }

    public function supprimerStatutJury($id)
    {
        // À implémenter
        header('Location: /parametres/statuts-jury');
        exit;
    }

    // === MÉTHODES POUR LES TYPES UTILISATEURS ===

    public function listeTypesUtilisateurs()
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/types_utilisateurs/liste.php';
    }

    public function ajouterTypeUtilisateur()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Implémentation
        }
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/types_utilisateurs/ajouter.php';
    }

    public function modifierTypeUtilisateur($id)
    {
        // À implémenter
        include __DIR__ . '/../../ressources/views/admin/paramettre_genereaux/types_utilisateurs/modifier.php';
    }

    public function supprimerTypeUtilisateur($id)
    {
        // À implémenter
        header('Location: /parametres/types-utilisateurs');
        exit;
    }

    // === MÉTHODES API POUR LES APPELS AJAX ===

    public function apiListeActions()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]); // Remplacer par les données réelles
        exit;
    }

    public function apiListeAnneesAcademiques()
    {
        $annees = $this->anneeAcademique->getAllAnneeAcademiques();
        header('Content-Type: application/json');
        echo json_encode($annees);
        exit;
    }

    public function apiListeECUEs()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeUEs()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeFonctions()
    {
        $fonctions = $this->fonction->getAllFonctions();
        header('Content-Type: application/json');
        echo json_encode($fonctions);
        exit;
    }

    public function apiListeGrades()
    {
        $grades = $this->grade->getAllGrades();
        header('Content-Type: application/json');
        echo json_encode($grades);
        exit;
    }

    public function apiListeGroupesUtilisateurs()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeNiveauxAccesDonnees()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeNiveauxApprobation()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeNiveauxEtude()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeSpecialites()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeStatutsJury()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }

    public function apiListeTypesUtilisateurs()
    {
        // À implémenter
        header('Content-Type: application/json');
        echo json_encode([]);
        exit;
    }
}