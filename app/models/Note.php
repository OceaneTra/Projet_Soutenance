<?php


class Note {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByStudent($studentId) {
        $query = "SELECT n.*, u.lib_ue, u.credit
                 FROM notes n 
                 JOIN ue u ON n.id_ue = u.id_ue
                 WHERE n.num_etu = ? 
                 ORDER BY u.id_semestre";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNotesByEtudiant($etudiantId) {
        return $this->getByStudent($etudiantId);
    }

    public function updateNote($etudiantId, $ueId, $moyenne, $commentaire = null) {
        try {
            $query = "UPDATE notes 
                     SET moyenne = ?, commentaire = ?, date_modification = NOW() 
                     WHERE num_etu = ? AND id_ue = ?";
            
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$moyenne, $commentaire, $etudiantId, $ueId]);
        } catch(PDOException $e) {
            error_log("Erreur lors de la mise à jour de la note: " . $e->getMessage());
            return false;
        }
    }

    public function createNote($etudiantId, $ueId, $moyenne, $commentaire = null) {
        try {
            $query = "INSERT INTO notes (num_etu, id_ue, moyenne, commentaire, date_evaluation) 
                     VALUES (?, ?, ?, ?, NOW())";
            
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$etudiantId, $ueId, $moyenne, $commentaire]);
        } catch(PDOException $e) {
            error_log("Erreur lors de la création de la note: " . $e->getMessage());
            return false;
        }
    }
} 