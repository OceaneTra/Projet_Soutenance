<?php
require_once __DIR__ . '/../../app/controllers/SauvegardeRestaurationController.php';

$controller = new SauvegardeRestaurationController();

// Affichage de la page
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/sauvegarde-restauration$#', $_SERVER['REQUEST_URI'])) {
    $controller->index();
    exit;
}

// Création d'une sauvegarde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('#^/sauvegarde-restauration/create$#', $_SERVER['REQUEST_URI'])) {
    $controller->createBackup();
    exit;
}

// Restauration depuis une sauvegarde existante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('#^/sauvegarde-restauration/restore$#', $_SERVER['REQUEST_URI'])) {
    $controller->restoreBackup();
    exit;
}

// Restauration depuis un upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('#^/sauvegarde-restauration/upload-restore$#', $_SERVER['REQUEST_URI'])) {
    $controller->uploadAndRestore();
    exit;
}

// Suppression d'une sauvegarde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && preg_match('#^/sauvegarde-restauration/delete$#', $_SERVER['REQUEST_URI'])) {
    $controller->deleteBackup();
    exit;
}

// Téléchargement d'une sauvegarde
if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match('#^/sauvegarde-restauration/download$#', $_SERVER['REQUEST_URI'])) {
    $controller->downloadBackup();
    exit;
} 