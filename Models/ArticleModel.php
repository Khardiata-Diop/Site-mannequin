<?php
require_once __DIR__ . '/Database.php';

class ArticleModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }
    
    // --- READ ---
    
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
    
    public function getAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM home_articles ORDER BY display_order ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function countAll() {
        $stmt = $this->pdo->prepare('SELECT COUNT(id) FROM home_articles');
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
     public function findById(int $id) {
        $sql = 'SELECT * FROM home_articles WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    // --- CREATE ---
    public function create(array $data): bool {
        $sql = 'INSERT INTO home_articles (title, content, image_path, image_alt, display_order, is_active) 
                VALUES (:title, :content, :image_path, :image_alt, :display_order, :is_active)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    // --- UPDATE ---
    public function update(int $id, array $data): bool {
        $data['id'] = $id;
        $sql = 'UPDATE home_articles SET 
                    title = :title, 
                    content = :content, 
                    image_path = :image_path, 
                    image_alt = :image_alt, 
                    display_order = :display_order, 
                    is_active = :is_active 
                WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }
    
    // --- DELETE ---
    public function delete(int $id): bool {
        $sql = 'DELETE FROM home_articles WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

}