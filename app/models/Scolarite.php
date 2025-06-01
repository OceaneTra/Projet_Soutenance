<?php

class Scolarite {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer le montant de la scolarité pour un niveau d'études
    public function getMontantScolarite($id_niveau) {
        $query = "SELECT montant_scolarite FROM niveau_etude WHERE id_niv_etude= ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_niveau]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['montant_scolarite'];
    }

    // Créer une inscription avec le premier versement
    public function creerInscription($id_etudiant, $id_niveau, $montant_premier_versement) {
        $this->db->beginTransaction();
        try {
            // Créer l'inscription
            $query = "INSERT INTO inscriptions (id_etudiant, id_niveau, date_inscription, statut_inscription) 
                     VALUES (?, ?, NOW(), 'En cours')";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_etudiant, $id_niveau]);
            $id_inscription = $this->db->lastInsertId();

            // Enregistrer le premier versement
            $query = "INSERT INTO versements (id_inscription, montant, date_versement, type_versement, statut_versement) 
                     VALUES (?, ?, NOW(), 'Premier versement', 'Validé')";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_inscription, $montant_premier_versement]);

            $this->db->commit();
            return $id_inscription;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Récupérer les étudiants non inscrits
    public function getEtudiantsNonInscrits() {
        $query = "SELECT e.* FROM etudiants e 
                 LEFT JOIN inscriptions i ON e.num_etu = i.id_etudiant 
                 WHERE i.id_inscription IS NULL";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les informations d'un étudiant
    public function getInfoEtudiant($num_etu) {
        $query = "SELECT num_etu, nom_etu, prenom_etu FROM etudiants WHERE num_etu = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les niveaux d'études
    public function getNiveauxEtudes() {
        $query = "SELECT * FROM niveau_etude";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function creerEcheance($id_inscription, $montant, $date_echeance) {
        $query = "INSERT INTO echeances (id_inscription, montant, date_echeance, statut_echeance) 
                 VALUES (?, ?, ?, 'En attente')";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id_inscription, $montant, $date_echeance]);
    }

    public function getEtudiantsInscrits() {
        $sql = "SELECT i.*, e.num_etu, e.nom_etu, e.prenom_etu, n.lib_niv_etude 
                FROM inscriptions i 
                JOIN etudiants e ON i.id_etudiant = e.num_etu
                JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude 
                ORDER BY i.date_inscription DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 