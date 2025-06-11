<?php
require_once __DIR__ . '/Database.php';

class MessageModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

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
}