<?php

include_once __DIR__ . '/../models/Traitement.php';

class MenuController {


    public function genererMenu($idGroupe) {
        $traitement = new Traitement(Database::getConnection());

        return $traitement->getTraitementByGU($idGroupe);
    }
}