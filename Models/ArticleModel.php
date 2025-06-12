<?php
require_once __DIR__ . '/Database.php';

class ArticleModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Récupère tous les articles actifs en utilisant une requête préparée.
     * @return array La liste des articles actifs.
     */
    public function getActiveArticles() {
        // La requête SQL avec un placeholder nommé :is_active
        $sql = 'SELECT title, content, image_path, image_alt FROM home_articles WHERE is_active = :is_active ORDER BY display_order ASC';

        // Préparation de la requête
        $stmt = $this->pdo->prepare($sql);

        // Exécution en liant la valeur 1 au placeholder :is_active
        $stmt->execute([':is_active' => 1]);

        // Récupération des résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}