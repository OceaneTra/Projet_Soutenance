<?php

/**
 * Classe abstraite Model qui sert de base pour tous les modèles de l'application
 *
 * Cette classe fournit une connexion PDO partagée à la base de données et des méthodes
 * pour exécuter facilement des requêtes SQL.
 */
abstract class DbModel
{
    /**
     * @var PDO|null Instance partagée de la connexion PDO
     */
    private static ?PDO $pdo = null;

    /**
     * @var array Configuration de la base de données
     */
    private static array $dbConfig = [
        'host' => 'db',
        'dbname' => 'soutenance_manager',
        'charset' => 'utf8',
        'username' => 'root',
        'password' => 'password'
    ];

    /**
     * Définit la configuration de la base de données
     *
     * @param array $config Configuration de la DB (host, dbname, charset, username, password)
     */
    public static function setDbConfig(array $config): void
    {
        self::$dbConfig = array_merge(self::$dbConfig, $config);
    }

    /**
     * Établit la connexion à la base de données
     *
     * @throws PDOException Si la connexion échoue
     */
    private static function setBdd(): void
    {
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            self::$dbConfig['host'],
            self::$dbConfig['dbname'],
            self::$dbConfig['charset']
        );

        self::$pdo = new PDO(
            $dsn,
            self::$dbConfig['username'],
            self::$dbConfig['password']
        );

        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /**
     * Retourne l'instance de la connexion PDO (la crée si nécessaire)
     *
     * @return PDO L'instance de la connexion PDO
     */
    protected function getBdd(): PDO
    {
        if (self::$pdo === null) {
            self::setBdd();
        }
        return self::$pdo;
    }

    /**
     * Exécute une requête SELECT et retourne tous les résultats
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @param bool $asObject Si true, retourne des objets (FETCH_OBJ), sinon tableau associatif
     * @return array Tableau des résultats
     * @throws PDOException Si la requête échoue
     */
    protected function selectAll(string $sql, array $params = [], bool $asObject = false): array
    {
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll($asObject ? PDO::FETCH_OBJ : PDO::FETCH_ASSOC);
    }

    /**
     * Exécute une requête SELECT et retourne un seul résultat
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @param bool $asObject Si true, retourne un objet (FETCH_OBJ), sinon tableau associatif
     * @return array|object|null Un résultat, ou null si aucun résultat
     * @throws PDOException Si la requête échoue
     */
    protected function selectOne(string $sql, array $params = [], bool $asObject = false): array|object|null
    {
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch($asObject ? PDO::FETCH_OBJ : PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Exécute une requête INSERT et retourne l'ID du dernier élément inséré
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return int ID du dernier élément inséré
     * @throws PDOException Si la requête échoue
     */
    protected function insert(string $sql, array $params = []): int
    {
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute($params);
        return (int) $this->getBdd()->lastInsertId();
    }

    /**
     * Exécute une requête UPDATE
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return int Nombre de lignes affectées
     * @throws PDOException Si la requête échoue
     */
    protected function update(string $sql, array $params = []): int
    {
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->rowCount();
    }

    /**
     * Exécute une requête DELETE
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return int Nombre de lignes affectées
     * @throws PDOException Si la requête échoue
     */
    protected function delete(string $sql, array $params = []): int
    {
        return $this->update($sql, $params);
    }

    /**
     * Exécute une requête générique (pour les autres types de requêtes)
     *
     * @param string $sql Requête SQL
     * @param array $params Paramètres pour la requête préparée
     * @return int Nombre de lignes affectées
     * @throws PDOException Si la requête échoue
     */
    protected function executeQuery(string $sql, array $params = []): int
    {
        $stmt = $this->getBdd()->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}