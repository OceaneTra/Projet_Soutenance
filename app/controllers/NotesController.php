<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/AnneeAcademique.php';
require_once __DIR__ . '/../models/Note.php';
require_once __DIR__ . '/../models/Ue.php';
require_once __DIR__ . '/../models/NiveauEtude.php';
require_once __DIR__ . '/../models/Ecue.php';


class NotesController {
    private $notesModel;
    private $etudiantsModel;
    private $ueModel;
    private $niveauEtudeModel;

    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->notesModel = new Note(db: $this->db);
        $this->etudiantsModel = new Etudiant($this->db);
        $this->ueModel = new UE($this->db);
        $this->niveauEtudeModel = new NiveauEtude($this->db);
    }

    public function index() {
        $niveauxEtude = $this->niveauEtudeModel->getAllNiveauxEtudes();
        $selectedNiveau = isset($_GET['niveau_id']) ? $_GET['niveau_id'] : null;
        $selectedStudent = null;
        $studentGrades = [];
        
        // Récupérer les étudiants filtrés par niveau si un niveau est sélectionné
        if ($selectedNiveau) {
            $etudiants = $this->etudiantsModel->getEtudiantsByNiveau($selectedNiveau);
            
            // Si un étudiant est sélectionné, récupérer ses notes
            if (isset($_GET['student_id'])) {
                $student = $this->etudiantsModel->getEtudiantById($_GET['student_id']);
                if ($student) {
                    // Convertir l'objet en tableau associatif
                    $selectedStudent = (array)$student;
                    $studentGrades = $this->notesModel->getNotesByEtudiant($selectedStudent['num_etu']);
                }
            }
        } else {
            $etudiants = [];
        }

        $GLOBALS['listeEtudiants'] = $etudiants;
        $GLOBALS['niveauxEtude'] = $niveauxEtude;
        $GLOBALS['selectedNiveau'] = $selectedNiveau;
        $GLOBALS['selectedStudent'] = $selectedStudent;
        $GLOBALS['studentGrades'] = $studentGrades;
    }

    public function updateNote() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['student_id'], $data['ue_id'], $data['note'])) {
                $success = $this->notesModel->updateNote(
                    $data['student_id'],
                    $data['ue_id'],
                    $data['note'],
                    $data['commentaire'] ?? null
                );
                
                echo json_encode(['success' => $success]);
                exit;
            }
        }
        
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
    }

    public function getNotesByEtudiant() {
        if (isset($_GET['student_id'])) {
            $notes = $this->notesModel->getNotesByEtudiant($_GET['student_id']);
            echo json_encode($notes);
            exit;
        }
        
        echo json_encode([]);
    }
} 