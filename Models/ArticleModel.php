<?php
require_once __DIR__ . '/Database.php';

class ArticleModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function getActiveArticles() {
        $stmt = $this->pdo->query('SELECT title, content, image_path, image_alt FROM home_articles WHERE is_active = 1 ORDER BY display_order ASC');
        return $stmt->fetchAll();
    }
}