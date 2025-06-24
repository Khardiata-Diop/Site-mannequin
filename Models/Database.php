<?php

/**
 * Gère la connexion à la base de données .
 *
 * Cette classe fournit un point d'accès unique et global à l'objet de connexion PDO.
 * Elle s'assure qu'une seule connexion est créée par requête (lazy initialization), 
 * ce qui optimise les ressources et prévient les erreurs liées à des connexions multiples.
 */
class Database 
{
    /**
     * L'instance unique et statique de l'objet PDO.
     * 
     * Initialisée à `null`, elle ne sera instanciée que lors du premier appel
     * à `getConnection()`. Étant `private` et `static`, elle n'est accessible
     * qu'à l'intérieur de cette classe et sa valeur est partagée à travers
     * tous les appels statiques.
     *
     * @var PDO|null L'objet PDO ou null si la connexion n'a pas encore été établie.
     */
    private static ?PDO $pdo = null;

    /**
     * Récupère l'instance unique de la connexion PDO à la base de données.
     *
     * C'est la seule méthode publique de la classe. Lors du premier appel, elle
     * initialise la connexion PDO en utilisant les credentials stockés dans les
     * variables d'environnement. Lors des appels suivants, elle retourne
     * simplement l'instance déjà créée et stockée dans la propriété `self::$pdo`.
     *
     * @return PDO L'objet de connexion PDO prêt à être utilisé.
     *             En cas d'échec de la connexion, le script s'arrête (`die`).
     */
    public static function getConnection(): PDO 
    {
        // Vérifie si la connexion n'a pas déjà été initialisée.
        // C'est le cœur du pattern Singleton (lazy initialization).
        if (self::$pdo === null) {
            
            /**
             * @var string $dsn Le Data Source Name pour la connexion PDO.
             * Il est construit à partir des variables d'environnement pour une
             * meilleure portabilité et sécurité (pas de credentials en dur dans le code).
             */
            $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8mb4";
            
            /**
             * @var array $options Options de configuration pour la connexion PDO.
             */
            $options = [
                // Configure le mode de rapport d'erreurs. PDO::ERRMODE_EXCEPTION fait que PDO lance des exceptions
                // de type PDOException en cas d'erreur, ce qui permet de les attraper dans un bloc try-catch.
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                
                // Définit le mode de récupération des résultats par défaut. PDO::FETCH_ASSOC retourne les
                // résultats sous forme de tableau associatif (nom_colonne => valeur).
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                
                // Désactive l'émulation des requêtes préparées. Mettre à `false` force PDO à utiliser
                // les vraies requêtes préparées du SGBD, ce qui est plus sécurisé contre les injections SQL.
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                /**
                 * Tente de créer une nouvelle instance de PDO et de l'assigner
                 * à la propriété statique `self::$pdo`.
                 */
                self::$pdo = new PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $options);
            } catch (\PDOException $e) {
                // En cas d'échec de la connexion, une exception PDOException est levée.
                
                // Enregistre le message d'erreur technique dans les logs du serveur.
                // C'est une bonne pratique pour ne pas exposer de détails sensibles à l'utilisateur.
                error_log($e->getMessage());

                // Arrête l'exécution du script et affiche un message générique à l'utilisateur.
                // En environnement de production, c'est une manière simple de gérer une erreur fatale.
                die('Erreur de connexion à la base de données.');
            }
        }

        // Retourne l'instance PDO (soit nouvellement créée, soit celle qui existait déjà).
        return self::$pdo;
    }
}