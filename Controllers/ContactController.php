<?php

// Dépendance vers le modèle qui gère les messages
    require_once __DIR__ . '/../Models/MessageModel.php';
    
class ContactController {
    /**
     * @var string L'URL de base de l'application.
     */
    private $baseUrl;

    /**
     * Le constructeur reçoit l'URL de base du routeur.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Affiche la page de contact et les messages "flash" (succès/erreur).
     */
    public function index() {
        // Récupérer les messages stockés en session (s'ils existent)
        $successMessage = $_SESSION['success_message'] ?? null;
        $errors = $_SESSION['errors'] ?? null;
        
        // Nettoyer la session pour que les messages ne s'affichent qu'une seule fois
        unset($_SESSION['success_message'], $_SESSION['errors']);

        // Appeler la méthode render avec les données
        $this->render('contact', [
            'pageTitle' => "Contact",
            'currentPage' => "contact",
            'successMessage' => $successMessage,
            'errors' => $errors
        ]);
    }

    /**
     * Traite la soumission du formulaire de contact.
     */
    public function submit() {
        // Sécurité : vérifier que la requête est bien de type POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->baseUrl . '/index.php?page=contact');
            exit;
        }

        // Nettoyer et valider les données du formulaire
        $surname = trim($_POST['surname'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        $errors = [];
        if (empty($surname)) $errors['surname'] = "Le nom est requis.";
        if (empty($name)) $errors['name'] = "Le prénom est requis.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "L'adresse email n'est pas valide.";
        if (empty($subject)) $errors['subject'] = "Le sujet est requis.";
        if (empty($message)) $errors['message'] = "Le message ne peut pas être vide.";

        // Si des erreurs sont trouvées, les stocker en session et rediriger vers le formulaire
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . $this->baseUrl . '/index.php?page=contact');
            exit;
        }

        // Si tout est valide, sauvegarder le message via le modèle
        $messageModel = new MessageModel();
        $success = $messageModel->saveMessage($name, $surname, $email, $subject, $message);

        // Stocker un message de succès ou d'échec en session
        if ($success) {
            $_SESSION['success_message'] = "Votre message a bien été envoyé. Merci !";
        } else {
            $_SESSION['errors']['submit'] = "Une erreur est survenue lors de l'envoi. Veuillez réessayer.";
        }
        
        // Rediriger vers la page de contact pour afficher le message (pattern Post-Redirect-Get)
        header('Location: ' . $this->baseUrl . '/index.php?page=contact');
        exit;
    }
    
    /**
     * Méthode générique pour rendre une vue avec son template.
     * @param string $viewName Le nom du fichier de la vue.
     * @param array $data Les données à passer à la vue.
     */
    protected function render(string $viewName, array $data = []) {
        // Ajoute l'URL de base aux données pour qu'elle soit accessible dans toutes les vues
        $data['baseUrl'] = $this->baseUrl;

        extract($data);
        require_once __DIR__ . '/../Views/templates/header.php';
        require_once __DIR__ . '/../Views/' . $viewName . '.php';
        require_once __DIR__ . '/../Views/templates/footer.php';
    }
}