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
    public function creerInscription($id_etudiant, $id_niveau, $id_annee_acad, $montant_premier_versement,$nombre_tranches,$reste_a_payer) {
        $this->db->beginTransaction();
        try {
            // Créer l'inscription
            $query = "INSERT INTO inscriptions (id_etudiant, id_niveau, id_annee_acad, date_inscription, statut_inscription,nombre_tranche,reste_a_payer) 
                     VALUES (?, ?, ?, NOW(), 'En cours',?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_etudiant, $id_niveau, $id_annee_acad,$nombre_tranches,$reste_a_payer]);
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
        $query = "SELECT num_etu, nom_etu, prenom_etu FROM etudiants WHERE num_etu NOT IN (SELECT id_etudiant FROM inscriptions)";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les informations d'un étudiant
    public function getInfoEtudiant($numEtu) {
        $query = "SELECT num_etu, nom_etu, prenom_etu FROM etudiants WHERE num_etu = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$numEtu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les niveaux d'études
    public function getNiveauxEtudes() {
        $query = "SELECT id_niv_etude, lib_niv_etude,montant_scolarite, montant_inscription FROM niveau_etude";
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
        $query = "SELECT i.*, e.nom_etu as nom, e.prenom_etu as prenom, n.lib_niv_etude as nom_niveau, 
                        a.date_deb, a.date_fin
                 FROM inscriptions i 
                 JOIN etudiants e ON i.id_etudiant = e.num_etu 
                 JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude
                 JOIN annee_academique a ON i.id_annee_acad = a.id_annee_acad
                 ORDER BY i.date_inscription DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vérifier si un étudiant est déjà inscrit
    public function estEtudiantInscrit($num_etu) {
        $query = "SELECT COUNT(*) as count FROM inscriptions WHERE id_etudiant = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$num_etu]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // Vérifier si un étudiant est déjà inscrit pour une année académique spécifique
    public function estEtudiantInscritPourAnnee($num_etu, $id_annee_acad) {
        $query = "SELECT COUNT(*) as count FROM inscriptions WHERE id_etudiant = ? AND id_annee_acad = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$num_etu, $id_annee_acad]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // Modifier une inscription
    public function modifierInscription($id_inscription, $id_niveau, $id_annee_acad,$montant_premier_versement,$nombre_tranches) {
        $this->db->beginTransaction();
        try {
            // Mettre à jour l'inscription
            $query = "UPDATE inscriptions SET id_niveau = ?, id_annee_acad = ?, nombre_tranche = ?  WHERE id_inscription = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_niveau,$id_annee_acad,$nombre_tranches, $id_inscription]);

            // Mettre à jour le premier versement
            $query = "UPDATE versements SET montant = ? WHERE id_inscription = ? AND type_versement = 'Premier versement'";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$montant_premier_versement, $id_inscription]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Supprimer les échéances d'une inscription
    public function supprimerEcheances($id_inscription) {
        $query = "DELETE FROM echeances WHERE id_inscription = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id_inscription]);
    }

    // Supprimer une inscription
    public function supprimerInscription($id_inscription) {
        $this->db->beginTransaction();
        try {
            // Supprimer d'abord les versements
            $query = "DELETE FROM versements WHERE id_inscription = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_inscription]);

            // Puis supprimer l'inscription
            $query = "DELETE FROM inscriptions WHERE id_inscription = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_inscription]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Récupérer une inscription par son ID
    public function getInscriptionById($id_inscription) {
        $query = "SELECT i.*, n.lib_niv_etude as nom_niveau, n.montant_scolarite as montant_total, 
                        a.date_deb, a.date_fin, v.montant as montant_premier_versement 
                 FROM inscriptions i 
                 JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude 
                 JOIN annee_academique a ON i.id_annee_acad = a.id_annee_acad 
                 LEFT JOIN versements v ON i.id_inscription = v.id_inscription AND v.type_versement = 'Premier versement'
                 WHERE i.id_inscription = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_inscription]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 