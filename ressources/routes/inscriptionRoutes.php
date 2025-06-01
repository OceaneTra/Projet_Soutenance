<?php
if ($_GET['page'] === 'gestion_etudiants' && $_GET['action']='inscrire_des_etudiants') {
    require_once __DIR__ . '/../../app/controllers/InscriptionController.php';
    $controller = new InscriptionController();

    $controller->index();

}