<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/Entreprise.php';


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


    //=============================Gestion de la demande de candidature=============================
    public function demande_candidature()
    {
      




       
} 
    
      //=============================COMPTE RENDU DE RAPPORTS =============================
    public function compteRenduRapport()
    {
    }

}