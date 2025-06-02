<?php

require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/GestionScolariteController.php';

// Déterminer l'action demandée. Utiliser $_REQUEST pour gérer GET et POST.
$action = $_REQUEST['action'] ?? null;


$controller = new GestionScolariteController(Database::getConnection());

// Gérer les actions en fonction du paramètre 'action'
switch ($action) {
    case 'enregistrer_versement':
        // Gérer la soumission du formulaire d'ajout d'un versement (POST)
        $controller->enregistrerVersement();
        // Le contrôleur gère la redirection après l'enregistrement.
        break;

    case 'modifier_versement':
        // Gérer l'affichage du formulaire de modification (GET avec ID)
        // Le contrôleur gérera la récupération des données et l'affichage de la vue pré-remplie.
        $controller->modifierVersement();
        break;

    case 'mettre_a_jour_versement':
        // Gérer la soumission du formulaire de modification (POST avec ID et données)
        $controller->mettreAJourVersement();
        // Le contrôleur gère la redirection après la mise à jour.
        break;

    case 'supprimer_versement':
        // Gérer la suppression d'un versement (POST ou GET avec ID)
        $controller->supprimerVersement();
        // Le contrôleur gère la réponse (JSON ou redirection) et l'exit().
        break;

    case 'imprimer_recu':
        // Gérer l'impression du reçu d'un versement (GET avec ID)
        // Le contrôleur génère directement la sortie du reçu.
        $controller->imprimerRecu();
        break; // Le contrôleur gère probablement l'exit()

    // Ajoutez d'autres actions liées à la gestion de scolarité ici si nécessaire (ex: voir historique)

    default:
        // Action par défaut : afficher la page principale de gestion de scolarité (liste des versements)
        $controller->index();
        break;
}


?>