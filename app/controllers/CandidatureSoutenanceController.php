<?php
require_once __DIR__ . '/../config/database.php';


class CandidatureSoutenanceController {

    private $baseViewPath;

    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/candidature_soutenance/';
       
    }


    //=============================Gestion de la simulation=============================
    public function simulateur()
    {
    }
      //=============================COMPTE RENDU DE RAPPORTS =============================
    public function compteRenduRapport()
    {
    }

}