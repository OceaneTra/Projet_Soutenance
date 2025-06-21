<?php


class Note {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getByStudent($studentId) {
        $query = "SELECT n.*, u.lib_ue, u.credit, e.lib_ecue
                 FROM notes n 
                 LEFT JOIN ue u ON n.id_ue = u.id_ue
                 LEFT JOIN ecue e ON n.id_ecue = e.id_ecue
                 WHERE n.num_etu = ? 
                 ORDER BY u.id_semestre";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateNote($etudiantId, $ueId, $moyenne, $commentaire, $ecueId ) {
        try {
            if ($ecueId) {
                $query = "UPDATE notes 
                         SET moyenne = ?, commentaire = ?, date_modification = NOW() 
                         WHERE num_etu = ? AND id_ecue = ? AND id_ue = ?";
                
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$moyenne, $commentaire, $etudiantId, $ecueId, $ueId]);
            } else {
                $query = "UPDATE notes 
                         SET moyenne = ?, commentaire = ?, date_modification = NOW() 
                         WHERE num_etu = ? AND id_ue = ?";
                
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$moyenne, $commentaire, $etudiantId, $ueId]);
            }
        } catch(PDOException $e) {
            error_log("Erreur lors de la mise à jour de la note: " . $e->getMessage());
            return false;
        }
    }

    public function createNote($etudiantId, $ueId, $moyenne, $commentaire = null, $ecueId = null) {
        try {
            if ($ecueId) {
                $query = "INSERT INTO notes (num_etu, id_ecue,id_ue, moyenne, commentaire, date_evaluation) 
                         VALUES (?, ?, ?, ?, ?, NOW())";
                
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$etudiantId, $ecueId, $ueId, $moyenne, $commentaire]);
            } else {
                $query = "INSERT INTO notes (num_etu, id_ue, moyenne, commentaire, date_evaluation) 
                         VALUES (?, ?, ?, ?, NOW())";
                
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$etudiantId, $ueId, $moyenne, $commentaire]);
            }
        } catch(PDOException $e) {
            error_log("Erreur lors de la création de la note: " . $e->getMessage());
            return false;
        }
    }

    public function deleteNote($etudiantId, $ueId = null, $ecueId = null) {
        try {
            if ($ecueId) {
                $query = "DELETE FROM notes WHERE num_etu = ? AND id_ecue = ?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$etudiantId, $ecueId]);
            } else {
                $query = "DELETE FROM notes WHERE num_etu = ? AND id_ue = ?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$etudiantId, $ueId]);
            }
        } catch(PDOException $e) {
            error_log("Erreur lors de la suppression de la note: " . $e->getMessage());
            return false;
        }
    }
} 