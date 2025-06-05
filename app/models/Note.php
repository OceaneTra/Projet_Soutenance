<?php


class Note {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getNotesByEtudiant($etudiantId) {
        $query = "SELECT n.*, u.lib_ue, u.credit
                 FROM notes n 
                 JOIN ue u ON n.ue_id = u.id_ue
                 WHERE n.etudiant_id = ? 
                 ORDER BY u.id_semestre";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$etudiantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateNote($etudiantId, $ueId, $note, $commentaire = null) {
        try {
            $query = "UPDATE notes 
                     SET note = ?, commentaire = ?, date_modification = NOW() 
                     WHERE etudiant_id = ? AND ue_id = ?";
            
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$note, $commentaire, $etudiantId, $ueId]);
        } catch(PDOException $e) {
            error_log("Erreur lors de la mise à jour de la note: " . $e->getMessage());
            return false;
        }
    }

    public function createNote($etudiantId, $ueId, $note, $commentaire = null) {
        try {
            $query = "INSERT INTO notes (etudiant_id, ue_id, note, commentaire, date_evaluation) 
                     VALUES (?, ?, ?, ?, NOW())";
            
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$etudiantId, $ueId, $note, $commentaire]);
        } catch(PDOException $e) {
            error_log("Erreur lors de la création de la note: " . $e->getMessage());
            return false;
        }
    }
} 