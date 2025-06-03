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
    public function creerInscription($id_etudiant, $id_niveau, $id_annee_acad, $montant_premier_versement,$nombre_tranches,$reste_a_payer,$methode_paiement) {
        $this->db->beginTransaction();
        try {
            // Créer l'inscription
            $query = "INSERT INTO inscriptions (id_etudiant, id_niveau, id_annee_acad, date_inscription, statut_inscription,nombre_tranche,reste_a_payer) 
                     VALUES (?, ?, ?, NOW(), 'En cours',?,?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_etudiant, $id_niveau, $id_annee_acad,$nombre_tranches,$reste_a_payer]);
            $id_inscription = $this->db->lastInsertId();

            // Enregistrer le premier versement
            $query = "INSERT INTO versements (id_inscription, montant, date_versement, type_versement,methode_paiement) 
                     VALUES (?, ?, NOW(), 'Premier versement',?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_inscription, $montant_premier_versement,$methode_paiement]);

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
        $query = "SELECT i.*,v.*, e.nom_etu as nom, e.prenom_etu as prenom, n.lib_niv_etude as nom_niveau, 
                        a.date_deb, a.date_fin,n.montant_scolarite,n.montant_inscription
                 FROM inscriptions i 
                 JOIN etudiants e ON i.id_etudiant = e.num_etu 
                 JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude
                 JOIN annee_academique a ON i.id_annee_acad = a.id_annee_acad
                 JOIN versements v ON i.id_inscription = v.id_inscription
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
    public function modifierInscription($id_inscription, $id_niveau, $id_annee_acad,$montant_premier_versement,$nombre_tranches,$methode_versement) {
        $this->db->beginTransaction();
        try {
            // Mettre à jour l'inscription
            $query = "UPDATE inscriptions SET id_niveau = ?, id_annee_acad = ?, nombre_tranche = ?  WHERE id_inscription = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_niveau,$id_annee_acad,$nombre_tranches, $id_inscription]);

            // Mettre à jour le premier versement
            $query = "UPDATE versements SET montant = ?, methode_paiement = ? WHERE id_inscription = ? AND type_versement = 'Premier versement'";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$montant_premier_versement, $methode_versement, $id_inscription]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    // Récupérer la liste des années académiques
    public function getAnneesAcademiques() {
        $query = "SELECT id_annee_acad, date_deb, date_fin FROM annee_academique ORDER BY date_deb DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            // Supprimer d'abord les échéances
            $query = "DELETE FROM echeances WHERE id_inscription = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_inscription]);

            // Supprimer ensuite les versements
            $query = "DELETE FROM versements WHERE id_inscription = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$id_inscription]);

            // Enfin supprimer l'inscription
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
                        a.date_deb, a.date_fin, v.montant as montant_premier_versement ,v.methode_paiement as methode_paiement,
                        e.nom_etu as nom_etudiant, e.prenom_etu as prenom_etudiant
                 FROM inscriptions i 
                 JOIN niveau_etude n ON i.id_niveau = n.id_niv_etude 
                 JOIN annee_academique a ON i.id_annee_acad = a.id_annee_acad 
                 JOIN etudiants e ON i.id_etudiant = e.num_etu
                 LEFT JOIN versements v ON i.id_inscription = v.id_inscription AND v.type_versement = 'Premier versement'
                 WHERE i.id_inscription = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_inscription]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les versements avec les informations associées
    public function getAllVersements() {
        $query = "SELECT v.*, e.nom_etu as nom_etudiant, e.prenom_etu as prenom_etudiant, i.id_inscription 
                  FROM versements v
                  JOIN inscriptions i ON v.id_inscription = i.id_inscription
                  JOIN etudiants e ON i.id_etudiant = e.num_etu
                  ORDER BY v.date_versement DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un versement par son ID
    public function getVersementById($id_versement) {
        $query = "SELECT v.*, e.nom_etu as nom_etudiant, e.prenom_etu as prenom_etudiant, i.id_inscription 
                  FROM versements v
                  JOIN inscriptions i ON v.id_inscription = i.id_inscription
                  JOIN etudiants e ON i.id_etudiant = e.num_etu
                  WHERE v.id_versement = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_versement]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un nouveau versement
    public function addVersement($data) {
        $this->db->beginTransaction();
        try {
            // Insérer le nouveau versement
            $queryVersement = "INSERT INTO versements (id_inscription, montant, date_versement, type_versement, methode_paiement) VALUES (?, ?, ?, ?, ?)";
            $stmtVersement = $this->db->prepare($queryVersement);
            $stmtVersement->execute([
                $data['id_inscription'],
                $data['montant'],
                $data['date_versement'],
                $data['type'] ?? 'Tranche', // Utiliser un type par défaut si non spécifié
                $data['methode_paiement']
            ]);

            // Mettre à jour le reste à payer dans la table inscriptions
            // Récupérer le reste à payer actuel
            $querySelectReste = "SELECT reste_a_payer FROM inscriptions WHERE id_inscription = ?";
            $stmtSelectReste = $this->db->prepare($querySelectReste);
            $stmtSelectReste->execute([$data['id_inscription']]);
            $inscription = $stmtSelectReste->fetch(PDO::FETCH_ASSOC);

            if ($inscription) {
                $nouveauResteAPayer = $inscription['reste_a_payer'] - $data['montant'];
                // S'assurer que le reste à payer ne devient pas négatif
                $nouveauResteAPayer = max(0, $nouveauResteAPayer);

                $queryUpdateInscription = "UPDATE inscriptions SET reste_a_payer = ? WHERE id_inscription = ?";
                $stmtUpdateInscription = $this->db->prepare($queryUpdateInscription);
                $stmtUpdateInscription->execute([$nouveauResteAPayer, $data['id_inscription']]);
            } else {
                // Gérer le cas où l'inscription n'est pas trouvée (cela ne devrait pas arriver si l'id_inscription est valide)
                throw new Exception("Inscription non trouvée pour la mise à jour du reste à payer.");
            }

            $this->db->commit();
            return true; // Indique que l'ajout et la mise à jour ont réussi
        } catch (Exception $e) {
            $this->db->rollBack();
            // Log l'erreur ou la gérer autrement
            // echo "Erreur lors de l'ajout du versement et de la mise à jour de l'inscription : " . $e->getMessage();
            return false; // Indique que l'opération a échoué
        }
    }

    // Modifier un versement existant
    public function updateVersement($id_versement, $data) {
        // Assurez-vous que $data contient les clés nécessaires à la mise à jour (montant, date_versement, methode_paiement, type)
        $query = "UPDATE versements SET montant = ?, date_versement = ?, methode_paiement = ?, type = ? WHERE id_versement = ?";
        $stmt = $this->db->prepare($query);
         // Le type doit être inclus dans $data si vous voulez le modifier, sinon utilisez le type existant ou un type par défaut.
        // Pour simplifier, on suppose que le type n'est pas modifiable via ce formulaire ou utilise un type générique.
        // Si le type doit être mis à jour, assurez-vous que $data['type'] existe.
        $type = isset($data['type']) ? $data['type'] : 'Tranche'; // Utiliser le type des données ou un défaut
        return $stmt->execute([$data['montant'], $data['date_versement'], $data['methode_paiement'], $type, $id_versement]);
    }

    // Supprimer un versement
    public function deleteVersement($id_versement) {
        $query = "DELETE FROM versements WHERE id_versement = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id_versement]);
    }

    // Récupérer l'ID de l'inscription par ID de l'étudiant
    public function getInscriptionByEtudiantId($id_etudiant) {
        $query = "SELECT id_inscription FROM inscriptions WHERE id_etudiant = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id_etudiant]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne la première inscription trouvée
    }
} 