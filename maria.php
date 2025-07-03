<?php

final class MariaDbConnection
{
    /** @var \PDO|null */
    private static $pdo = null;

    /**
     * Get a singleton PDO connection to the MariaDB server.
     *
     * @return \PDO
     * @throws \PDOException on connection failure
     */
    public static function getConnection(): \PDO
    {
        if (self::$pdo instanceof \PDO) {
            return self::$pdo;
        }

        $host     = '127.0.0.1';
        $port     = 3389;
        $dbname   = 'proddata';
        $username = 'root';
        $password = '';   

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4"; // MariaDB uses the mysql PDO driver

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_PERSISTENT         => false,
        ];

        self::$pdo = new \PDO($dsn, $username, $password, $options);

        // quick sanity log – optional
        $stmt = self::$pdo->query('SELECT VERSION() AS v');
        error_log('[MariaDB] Connected, server version: ' . $stmt->fetch()['v']);

        return self::$pdo;
    }

    // Disallow instantiation
    private function __construct() {}
}
