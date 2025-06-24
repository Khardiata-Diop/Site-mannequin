<?php
require_once __DIR__ . '/Database.php';

class MessageModel {
    private $pdo;
    
    /**
     * Constructeur qui charge la connexion PDO via la classe Database.
     * Aucun paramètre n'est attendu.
     */

    public function __construct() {
        $this->pdo = Database::getConnection();
    }
    /**
     * Sauvegarde un message de contact envoyé via la page de contact.
     * 
     * @param string $name Le prénom du destinataire.
     * @param string $surname Le nom du destinataire.
     * @param string $email L'adresse email du destinataire.
     * @param string $subject Le sujet du message.
     * @param string $message Le contenu du message.
     * 
     * @return bool True si le message a été sauvegardé, false sinon.
     */
    public function saveMessage(string $name, string $surname, string $email, string $subject, string $message): bool {
        $sql = "INSERT INTO contact_messages (name, surname, email, subject, message) VALUES (:name, :surname, :email, :subject, :message)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':name'    => $name,
                ':surname' => $surname,
                ':email'   => $email,
                ':subject' => $subject,
                ':message' => $message
            ]);
        } catch (\PDOException $e) {
            error_log('MessageModel Error: ' . $e->getMessage());
            return false;
        }
    }
       
    
    public function getAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM contact_messages ORDER BY submission_date DESC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $stmt = $this->pdo->prepare('SELECT COUNT(id) FROM contact_messages');
        $stmt->execute();
        return $stmt->fetchColumn();
       
    }
    
    public function findById(int $id) {
        $sql = 'SELECT * FROM contact_messages WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public function delete(int $id): bool {
        $sql = 'DELETE FROM contact_messages WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}