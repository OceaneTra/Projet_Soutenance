<?php

class Fonction {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les fonctions
    public function getAllFonctions() {
        $stmt = $this->pdo->query("SELECT * FROM fonction ORDER BY lib_fonction");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Générer un code pour une fonction
    private function genererCodeFonction($libelle) {
        $correspondances = [
            "responsable de filiere" => "RESP_FILIERE",
            "chef de departement" => "CHEF_DEP",
            "directeur de laboratoire" => "DIR_LABO",
            "doyen de faculte" => "DOYEN",
            "vice-doyen" => "V_DOYEN",
            "coordinateur pedagogique" => "COORD_PEDAGO",
            "responsable d'annee" => "RESP_ANNEE",
            "president de jury" => "PRES_JURY",
            "secretaire pedagogique" => "SECR_PEDAGO",
            "encadrant de memoire ou de these" => "ENCADREUR",
            "membre de commission pedagogique" => "MEMB_COM_PEDAGO",
            "responsable de stage" => "RESP_STAGE",
            "membre du conseil scientifique" => "MEMB_CONS_SCI",
            "responsable de la recherche" => "RESP_RECHERCHE",
            "responsable des relations internationales" => "RESP_REL_INT",
            "responsable de la scolarite" => "RESP_SCOLARITE",
            "directeur d'ufr ou de composante" => "DIR_UFR",
            "responsable qualite" => "RESP_QUALITE"
        ];

        // Normalisation
        $libelle = strtolower(trim($libelle));
        $libelle = str_replace(
            ["é", "è", "ê", "ë", "à", "â", "ä", "î", "ï", "ô", "ö", "ù", "û", "ü", "ç", "'", "'"],
            ["e", "e", "e", "e", "a", "a", "a", "i", "i", "o", "o", "u", "u", "u", "c", "'", "'"],
            $libelle
        );

        return $correspondances[$libelle] ?? null;
    }

    // Ajouter une nouvelle fonction
    public function addFonction($lib_fonction) {
        $id_fonction = $this->genererCodeFonction($lib_fonction);

        if ($id_fonction === null) {
            return false;
        }

        $stmt = $this->pdo->prepare("INSERT INTO fonction (id_fonction, lib_fonction) VALUES (?, ?)");
        return $stmt->execute([$id_fonction, $lib_fonction]);
    }

    // Supprimer une fonction
    public function deleteFonction($id) {
        $stmt = $this->pdo->prepare("DELETE FROM fonction WHERE id_fonction = ?");
        return $stmt->execute([$id]);
    }
}