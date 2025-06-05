<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/Entreprise.php';
require_once __DIR__ . '/../models/InfoStage.php';


class CandidatureSoutenanceController {

    private $baseViewPath;

    private $etudiant;

  private $entreprise;

  private $db;


    public function __construct()
    {
        $this->baseViewPath = __DIR__ . '/../../ressources/views/candidature_soutenance/';
        $this->db = Database::getConnection();
        $this->etudiant = new Etudiant($this->db);
        $this->entreprise = new Entreprise($this->db);
       
    }

  public function index()
  {

    if(isset($_GET['action'])){
      switch($_GET['action']){
        case 'demande_candidature':
          $this->demande_candidature();
          break;
        case 'compte_rendu':
            $this->compteRenduRapport();
            break;
        case 'infoStage':
             $this->infoStage();
            break;
              
        
      }
    }
    
  }

    

    //=============================Gestion de la demande de candidature=============================
    public function demande_candidature()
    {
       
} 
    
      //=============================COMPTE RENDU DE RAPPORTS =============================
    public function compteRenduRapport()
    {
    }

      //=============================ENREGISTRER/ MODIFIER LES INFOS DE STAGE =============================
      public function infoStage()
      {
      }

}