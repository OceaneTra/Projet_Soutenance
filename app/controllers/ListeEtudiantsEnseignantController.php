<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Enseignant.php';
require_once __DIR__ . '/../models/Ecue.php';
require_once __DIR__ . '/../models/Ue.php';
require_once __DIR__ . '/../models/Etudiant.php';

class ListeEtudiantsEnseignantController
{
    private $enseignant;
    private $ecue;
    private $ue;
    private $etudiant;
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->enseignant = new Enseignant($this->db);
        $this->ecue = new Ecue($this->db);
        $this->ue = new Ue($this->db);
        $this->etudiant = new Etudiant($this->db);
    }

    public function index()
    {
        
    }
} 