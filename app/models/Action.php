<?php
require_once __DIR__ . '/../config/DbModel.class.php';

class Action extends DbModel
{
<<<<<<< HEAD
    /**
     * Récupérer toutes les actions
     * @return array Liste des actions
     */
    public function getAllAction(): array
    {
        return $this->selectAll("SELECT * FROM action", [], true);
    }

    /**
     * Ajouter une nouvelle action
     * @param string $libelle Le libellé de l'action
     * @return bool|int L'ID de l'action créée ou false si échec
     */
    public function addAction(string $libelle): bool|int
    {
        return $this->insert(
            "INSERT INTO action (lib_action) VALUES (?)",
            [$libelle]
        );
    }

    /**
     * Mettre à jour une action
     * @param string $lib_action Le nouveau libellé de l'action
     * @param int $id_action L'ID de l'action à modifier
     * @return bool Succès de la mise à jour
     */
    public function updateAction(string $lib_action, int $id_action): bool
    {
        return $this->update(
                "UPDATE action SET lib_action = ? WHERE id_action = ?",
                [$lib_action, $id_action]
            ) > 0;
    }

    /**
     * Supprimer une action
     * @param int $id L'ID de l'action à supprimer
     * @return bool Succès de la suppression
     */
    public function deleteAction(int $id): bool
    {
        return $this->delete(
                "DELETE FROM action WHERE id_action = ?",
                [$id]
            ) > 0;
    }

    /**
     * Vérifier si une action existe
     * @param int $id L'ID de l'action à vérifier
     * @return bool True si l'action existe
     */
    public function isActionExiste(int $id): bool
    {
        return $this->selectOne(
                "SELECT COUNT(*) as count FROM action WHERE id_action = ?",
                [$id]
            )['count'] > 0;
    }

    /**
     * Récupérer une action par son ID
     * @param int $id_action L'ID de l'action à récupérer
     * @return object|null L'action trouvée ou null
     */
    public function getActionById(int $id_action): ?object
    {
        return $this->selectOne(
            "SELECT * FROM action WHERE id_action = ?",
            [$id_action],
            true
        );
=======

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterAction($lib_action)
    {
        $stmt = $this->db->prepare("INSERT INTO action (lib_action) VALUES (?)");
        return $stmt->execute([$lib_action]);
    }

    public function updateAction($id_action, $lib_action)
    {
        $stmt = $this->db->prepare("UPDATE action SET lib_action = ? WHERE id_action = ?");
        return $stmt->execute([$lib_action, $id_action]);
    }

    public function deleteAction($id_action)
    {
        $stmt = $this->db->prepare("DELETE FROM action WHERE id_action = ?");
        return $stmt->execute([$id_action]);
    }

    public function getActionById($id_action)
    {
        $stmt = $this->db->prepare("SELECT * FROM action WHERE id_action = ?");
        $stmt->execute([$id_action]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllAction()
    {
        $stmt = $this->db->prepare("SELECT * FROM action ORDER BY lib_action");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
>>>>>>> ca2717c9dd5fd17d8353b610c3251922be196b38
    }
}