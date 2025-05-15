<?php

class Etudiants
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $login_etu)
    {
        $stmt = $this->db->prepare("INSERT INTO etudiants (num_etu, nom_etu, prenom_etu, date_naiss_etu, genre_etu, login_etu, mdp_etu) VALUES (?,?,?,?,?,?,?)");
        return $stmt->execute([$num_etu, $nom_etu, $prenom_etu,$date_naiss_etu, $genre_etu, $login_etu, 'mdpParDefaut']);
    }

    public function updateEtudiant($num_etu, $nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $login_etu, $mdp_etu)
    {
        $stmt = $this->db->prepare("UPDATE etudiants SET nom_etu = ?, prenom_etu = ?, date_naiss_etu = ?, genre_etu = ?, login_etu = ?, mdp_etu = ? WHERE num_etu = ?");
        return $stmt->execute([$nom_etu, $prenom_etu, $date_naiss_etu, $genre_etu, $login_etu, $mdp_etu, $num_etu]);
    }

    public function deleteEtudiant($num_etu)
    {
        $stmt = $this->db->prepare("DELETE FROM etudiants WHERE num_etu = ?");
        return $stmt->execute([$num_etu]);
    }

    public function getEtudiantById($num_etu)
    {
        $stmt = $this->db->prepare("SELECT * FROM etudiants WHERE num_etu = ?");
        $stmt->execute([$num_etu]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllEtudiant()
    {
        echo "DEBUG MODEL: getAllEtudiant called<br>";

        try {
            $stmt = $this->db->prepare("SELECT * FROM etudiants ORDER BY num_etu DESC");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            echo "DEBUG MODEL: Found " . count($result) . " students<br>";

            return $result;
        } catch (PDOException $e) {
            echo "ERROR MODEL: " . $e->getMessage() . "<br>";
            return [];
        }
    }

}