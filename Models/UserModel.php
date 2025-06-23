<?php
// Models/UserModel.php

require_once __DIR__ . '/Database.php';

/**
 * Gère les opérations de la base de données pour la table `users`.
 */
class UserModel {
    /**
     * @var PDO L'instance de connexion à la base de données.
     */
    private $pdo;

    /**
     * Le constructeur initialise la connexion à la base de données.
     */
    public function __construct() {
        $this->pdo = Database::getConnection();
    }
    
     public function findById(int $id) {
        // On ne sélectionne pas le mot de passe pour des raisons de sécurité
        $sql = 'SELECT id, email, created_at FROM users WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Trouve un utilisateur dans la base de données par son adresse e-mail.
     * C'est la méthode utilisée pour la vérification lors de la connexion.
     *
     * @param string $email L'adresse e-mail de l'utilisateur à rechercher.
     * @return array|false Retourne les données de l'utilisateur (y compris le mot de passe hashé)
     *                     sous forme de tableau associatif s'il est trouvé, sinon retourne false.
     */
    public function findUserByEmail(string $email) {
        $sql = 'SELECT id, email, password FROM users WHERE email = :email';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(); // fetch() retourne une seule ligne ou false
    }

    /**
     * Récupère tous les utilisateurs de la base de données pour les lister dans l'interface d'administration.
     * Par sécurité, cette méthode NE sélectionne PAS le champ 'password'.
     *
     * @return array La liste de tous les utilisateurs.
     */
    public function getAll(): array {
        // Note : On ne sélectionne jamais le champ 'password' pour une liste.
        $sql = 'SELECT id, email, created_at FROM users ORDER BY created_at DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Compte le nombre total d'utilisateurs.
     * Peut être utile pour le tableau de bord ou la pagination.
     *
     * @return int Le nombre total d'utilisateurs.
     */
    public function countAll(): int {
        return (int) $this->pdo->query('SELECT COUNT(id) FROM users')->fetchColumn();
    }
    
    // --- Méthodes pour le CRUD (Create, Read, Update, Delete) ---
    // Ces méthodes seront utiles quand tu voudras ajouter, modifier ou supprimer des utilisateurs.

    /**
     * Crée un nouvel utilisateur.
     *
     * @param string $email L'email du nouvel utilisateur.
     * @param string $password Le mot de passe EN CLAIR (il sera hashé par la méthode).
     * @return bool True en cas de succès, false sinon.
     */
    public function create(string $email, string $password): bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':email' => $email,
            ':password' => $hashedPassword
        ]);
    }
    
     public function update(int $id, string $email, ?string $password): bool {
        // Si un nouveau mot de passe est fourni, on le met à jour
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = 'UPDATE users SET email = :email, password = :password WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['email' => $email, 'password' => $hashedPassword, 'id' => $id]);
        } 
        // Sinon, on met à jour uniquement l'email
        else {
            $sql = 'UPDATE users SET email = :email WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['email' => $email, 'id' => $id]);
        }
    }
    
     public function delete(int $id): bool {
        // Mesure de sécurité : ne pas permettre la suppression du tout premier admin (ID=1) qui me permet actuellement de me connecter 
        if ($id === 1) {
            return false;
        }
        $sql = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}