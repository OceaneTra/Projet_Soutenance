<?php
require_once __DIR__ . '/../config/database.php';


class GestionRapportController {

    private $baseViewPath;

    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/admin/partials/gestion_rapports/';
       
    }


    //=============================CREER UN RAPPORT=============================
    public function creerRapport()
    {
    }
     //=============================SUIVI DE DEPOT DE RAPPORT=============================
     public function suiviRapport()
     {
     }
      //=============================COMPTE RENDU DE RAPPORTS =============================
    public function compteRenduRapport()
    {
    }

}