<?php
require_once __DIR__ . '/../config/DbModel.class.php';
/**
 * Classe Fonction qui gère les opérations liées aux fonctions
 *
 * Cette classe étend DbModel pour bénéficier des méthodes génériques d'accès à la base de données.
 */
class Fonction extends DbModel
{
    /**
     * Récupérer toutes les fonctions
     * @return array Liste des fonctions
     */
    public function getAllFonctions(): array
    {
        return $this->selectAll("SELECT * FROM fonction ORDER BY lib_fonction", [], true);
    }

    /**
     * Générer un code pour une fonction
     * @param string $libelle Le libellé de la fonction
     * @return string|null Le code généré ou null si non trouvé
     */
    private function genererCodeFonction(string $libelle): ?string
    {
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

    /**
     * Ajouter une nouvelle fonction
     * @param string $lib_fonction Le libellé de la fonction
     * @return bool|int L'ID de la fonction créée ou false si échec
     */
    public function addFonction(string $lib_fonction): bool|int
    {
        $id_fonction = $this->genererCodeFonction($lib_fonction);

        if ($id_fonction === null) {
            return false;
        }

        return $this->insert(
            "INSERT INTO fonction (id_fonction, lib_fonction) VALUES (?, ?)",
            [$id_fonction, $lib_fonction]
        );
    }

    /**
     * Supprimer une fonction
     * @param string $id L'ID de la fonction à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteFonction(string $id): bool
    {
        return $this->delete("DELETE FROM fonction WHERE id_fonction = ?", [$id]) > 0;
    }

    /**
     * Récupérer une fonction par son ID
     * @param string $id L'ID de la fonction
     * @return object|null La fonction trouvée ou null
     */
    public function getFonctionById(string $id): ?object
    {
        return $this->selectOne(
            "SELECT * FROM fonction WHERE id_fonction = ?",
            [$id],
            true
        );
    }

    /**
     * Mettre à jour une fonction
     * 
     * @param int $id_fonction L'ID de la fonction à modifier
     * @param int $lib_fonction Le nouveau libellé de la fonction
     * @return bool Succès de la mise à jour
     */
    public function updateFonction(int $id_fonction, int $lib_fonction): bool
    {
        try {
            return $this->update(
                "UPDATE fonction SET lib_fonction = ? WHERE id_fonction = ?",
                [$lib_fonction, $id_fonction]
            ) > 0;
        } catch (PDOException $e) {
            error_log("Erreur de mise à jour de fonction: " . $e->getMessage());
            return false;
        }

    }
}