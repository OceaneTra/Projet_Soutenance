<?php
require_once __DIR__ . '/../config/DbModel.class.php';

/**
 * Classe AnneeAcademique qui gère les opérations liées aux années académiques
 * 
 * Cette classe étend DbModel pour bénéficier des méthodes génériques d'accès à la base de données
 */
class AnneeAcademique extends DbModel
{
    /**
     * Récupère toutes les années académiques triées par date de début décroissante
     * 
     * @return array Liste des années académiques
     */
    public function getAllAnneeAcademiques(): array
    {
        return $this->selectAll(
            "SELECT * FROM annee_academique ORDER BY date_deb DESC",
            [],
            true
        );
    }

    /**
     * Récupère une année académique par son ID
     * 
     * @param string $id_annee_acad L'ID de l'année académique
     * @return object|null L'année académique trouvée ou null
     */
    public function getAnneeAcademiqueById(string $id_annee_acad): ?object
    {
        return $this->selectOne(
            "SELECT * FROM annee_academique WHERE id_annee_acad = ?",
            [$id_annee_acad],
            true
        );
    }

    /**
     * Ajoute une nouvelle année académique
     * 
     * @param string $date_deb Date de début de l'année académique
     * @param string $date_fin Date de fin de l'année académique
     * @return bool|int L'ID de l'année académique créée ou false si échec
     */
    public function ajouterAnneeAcademique(string $date_deb, string $date_fin): bool|int
    {
        try {
            $annee1 = date("Y", strtotime($date_deb));
            $annee2 = date("Y", strtotime($date_fin));
            $id_annee_acad = substr($annee2, 0, 1) . substr($annee1, 2, 2) . substr($annee2, 2, 2);

            return $this->insert(
                "INSERT INTO annee_academique (id_annee_acad, date_deb, date_fin) VALUES (?, ?, ?)",
                [$id_annee_acad, $date_deb, $date_fin]
            );
        } catch (PDOException $e) {
            
            error_log("Erreur d'ajout d'année académique: " . $e->getMessage());
            return false;
        }
    }


    /**
     * Met à jour une année académique existante
     * 
     * @param string $id_annee_acad L'ID de l'année académique
     * @param string $date_deb Nouvelle date de début
     * @param string $date_fin Nouvelle date de fin
     * @return bool Succès de la mise à jour
     */
    public function updateAnneeAcademique(string $id_annee_acad, string $date_deb, string $date_fin): bool
    {
        try {
            
            return $this->update(
                "UPDATE annee_academique SET date_deb = ?, date_fin = ? WHERE id_annee_acad = ?",
                [$date_deb, $date_fin, $id_annee_acad]
            ) > 0;
        } catch (PDOException $e) {
            error_log("Erreur de mise à jour d'année académique: " . $e->getMessage());
            return false;
        }
    }
    

    /**
     * Supprime une année académique
     * 
     * @param string $id L'ID de l'année académique à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteAnneeAcademique(string $id): bool
    {
        try {
            return $this->delete(
                "DELETE FROM annee_academique WHERE id_annee_acad = ?",
                [$id]
            ) > 0;
        } catch (PDOException $e) {
            error_log("Erreur de suppression d'année académique: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifie si une année académique est utilisée dans d'autres tables
     * 
     * @param string $id L'ID de l'année académique
     * @return bool True si l'année académique est utilisée
     */
    public function isAnneeAcademiqueInUse(string $id): bool
    {
        // Vérification dans la table UE
        $result = $this->selectOne(
            "SELECT COUNT(*) as count FROM ue WHERE id_annee_academique = ?",
            [$id]
        );
        
        return $result['count'] > 0;
    }
}