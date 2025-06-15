<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AnneeAcademique.php';
require_once __DIR__ . '/../models/Note.php';
require_once __DIR__ . '/../models/Etudiant.php';
require_once __DIR__ . '/../models/NiveauEtude.php';
require_once __DIR__ . '/../models/Semestre.php';
require_once __DIR__ . '/../models/Ue.php';
require_once __DIR__ . '/../models/Ecue.php';



class NotesController {
    private $noteModel;
    private $etudiantModel;
    private $niveauModel;
    private $semestreModel;
    private $ueModel;
    private $ecueModel;
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->noteModel = new Note($this->db);
        $this->etudiantModel = new Etudiant($this->db);
        $this->ueModel = new Ue($this->db);
        $this->niveauModel = new NiveauEtude($this->db);
        $this->ecueModel = new Ecue($this->db);
        $this->semestreModel = new Semestre($this->db);
    }

    public function index() {

       if(isset($_GET['action']) && $_GET['action'] == 'enregistrer_notes'){
        $this->updateNote();
        
       }
       

        $selectedNiveau = isset($_GET['niveau']) ? (int)$_GET['niveau'] : null;
        $selectedStudent = isset($_GET['student']) ? $_GET['student'] : null;
        $selectedStudent = $selectedStudent ? $this->etudiantModel->getEtudiantById($selectedStudent) : null;

        $GLOBALS['niveaux'] = $this->niveauModel->getAllNiveauxEtudes();
        $GLOBALS['etudiants'] = $selectedNiveau ? $this->etudiantModel->getEtudiantsByNiveau($selectedNiveau) : [];
        $GLOBALS['selectedNiveau'] = $selectedNiveau;
        $GLOBALS['selectedStudent'] = $selectedStudent;

        $GLOBALS['listeEtudiants'] = $this->etudiantModel->getAllEtudiants();
        $GLOBALS['niveauxEtude'] = $this->niveauModel->getAllNiveauxEtudes();

        if ($selectedStudent) {
            $GLOBALS['studentGrades'] = $this->noteModel->getByStudent($selectedStudent->num_etu);
            $GLOBALS['studentSemestres'] = $selectedNiveau ? $this->semestreModel->getSemestresByNiveau($selectedNiveau) : [];
            $GLOBALS['studentUes'] = $selectedNiveau ? $this->ueModel->getUesByNiveau($selectedNiveau, $selectedStudent->num_etu) : [];
            $GLOBALS['studentEcues'] = $selectedNiveau ? $this->ecueModel->getEcuesByNiveau($selectedNiveau, $selectedStudent->num_etu) : [];
        } else {
            $GLOBALS['studentGrades'] = [];
            $GLOBALS['studentSemestres'] = $selectedNiveau ? $this->semestreModel->getSemestresByNiveau($selectedNiveau) : [];
            $GLOBALS['studentUes'] = $selectedNiveau ? $this->ueModel->getUesByNiveau($selectedNiveau) : [];
            $GLOBALS['studentEcues'] = $selectedNiveau ? $this->ecueModel->getEcuesByNiveau($selectedNiveau) : [];
        }

       
    }

    public function updateNote() {
        $data = json_decode(file_get_contents('php://input'), true);
        $success = true;

        foreach ($data as $note) {
            if (!$this->noteModel->updateNote($note['student_id'], $note['ue_id'], $note['note'], $note['commentaire'])) {
                $success = false;
                break;
            }
        }

        echo json_encode(['success' => $success]);
    }

    public function getNotesByEtudiant() {
        if (isset($_GET['student_id'])) {
            $notes = $this->noteModel->getByStudent($_GET['student_id']);
            echo json_encode($notes);
            exit;
        }
        
        echo json_encode([]);
    }
} 