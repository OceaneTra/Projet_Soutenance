<?php
require_once __DIR__ . '/../config/database.php';


class GestionReclamationsController {

    private $baseViewPath;

    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/admin/partials/gestion_reclamations/';
       
    }


    //=============================SOUMETTRE RECLAMATION=============================
    public function soumettreReclamations()
    {
    }
     //=============================SUIVI RECLAMATION=============================
     public function suiviReclamations()
     {
     }
      //=============================HISTORIQUE RECLAMATION=============================
    public function historiqueReclamations()
    {
    }

}