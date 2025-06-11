<?php
class Database {
    private static $pdo;

    public static function getConnection() {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
            } catch (\PDOException $e) {
                // En production, ne pas afficher les détails de l'erreur
                error_log($e->getMessage());
                die('Erreur de connexion à la base de données.');
            }
        }
        return self::$pdo;
    }
}