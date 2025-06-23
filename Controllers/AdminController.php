<?php
// Controllers/AdminController.php

// On charge tous les modèles dont on aura besoin
require_once __DIR__ . '/../Models/UserModel.php';
require_once __DIR__ . '/../Models/ArticleModel.php';
require_once __DIR__ . '/../Models/MessageModel.php';

/**
 * Contrôleur pour toute la section administration du site.
 */
class AdminController
{
    private $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Vérifie si l'administrateur est authentifié.
     * Si non, le redirige vers la page de connexion.
     * Cette méthode est appelée au début de chaque action protégée.
     */
    private function checkAuth(): void
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: ' . $this->baseUrl . '/index.php?page=login');
            exit;
        }
    }

    /**
     * Affiche la page de connexion.
     * C'est une méthode publique, pas besoin de checkAuth().
     */
    public function showLoginPage(): void
    {
        // Récupérer un éventuel message d'erreur de la session
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']); // On le supprime pour qu'il ne s'affiche qu'une fois

        // La page de login a sa propre structure HTML complète, on n'utilise pas le template admin.
        $pageTitle = 'Connexion - Administration';
        $baseUrl = $this->baseUrl;
        
        require_once __DIR__ . '/../Views/admin/login.php';
    }

    /**
     * Traite la soumission du formulaire de connexion.
     */
    public function handleLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->baseUrl . '/index.php?page=login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new UserModel();
        $user = $userModel->findUserByEmail($email);

        // Si l'utilisateur existe ET que le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            // Le mot de passe est bon, on connecte l'utilisateur
            
            // Régénère l'ID de session pour des raisons de sécurité (prévient la fixation de session)
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            header('Location: ' . $this->baseUrl . '/index.php?page=dashboard');
            exit;
        } else {
            // Identifiants incorrects
            $_SESSION['login_error'] = 'Email ou mot de passe incorrect.';
            header('Location: ' . $this->baseUrl . '/index.php?page=login');
            exit;
        }
    }

    /**
     * Déconnecte l'administrateur.
     */
    public function logout(): void
    {
        $this->checkAuth(); // On vérifie qu'on est connecté pour pouvoir se déconnecter
        
        session_unset();
        session_destroy();

        header('Location: ' . $this->baseUrl . '/index.php?page=login');
        exit;
    }

    /**
     * Affiche le tableau de bord principal.
     */
    public function showDashboard(): void
    {
        $this->checkAuth();
        
        $messageModel = new MessageModel();
        $articleModel = new ArticleModel();

        $data = [
            'pageTitle' => 'Tableau de Bord',
            'currentPage' => 'dashboard',
            'messageCount' => $messageModel->countAll(),
            'articleCount' => $articleModel->countAll()
        ];
        
        $this->renderAdmin('dashboard', $data);
    }

    /**
     * Affiche la liste des messages de contact.
     */
   
public function listMessages(): void
{
    $this->checkAuth();
        
        $messageModel = new MessageModel();
        
        $data = [
            'pageTitle' => 'Gestion des Messages',
            'currentPage' => 'messages',
            'messages' => $messageModel->getAll()
        ];
        
        $this->renderAdmin('messages_list', $data);
}
    
     public function showMessage(): void
    {
        $this->checkAuth();
        $id = (int)($_GET['id'] ?? 0);
        
        $messageModel = new MessageModel();
        $message = $messageModel->findById($id);

        if (!$message) {
            header('Location: ' . $this->baseUrl . '/index.php?page=admin-messages');
            exit;
        }

        $this->renderAdmin('message_view', [
            'message' => $message,
            'currentPage' => 'messages'
        ]);
    }

    public function deleteMessage(): void
    {
        $this->checkAuth();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $messageModel = new MessageModel();
            $messageModel->delete($id);
        }
        header('Location: ' . $this->baseUrl . '/index.php?page=admin-messages');
        exit;
    }
    
    /**
     * Affiche la liste des articles de la page d'accueil.
     */
    public function listArticles(): void
    {
        $this->checkAuth();
        
        $articleModel = new ArticleModel();
        
        $data = [
            'pageTitle' => 'Gestion des Articles',
            'currentPage' => 'articles',
            'articles' => $articleModel->getAll()
        ];
        
        $this->renderAdmin('articles_list', $data);
    }
    
    /**
     * Affiche le formulaire de création ou d'édition d'un article.
     */
    public function showArticleForm(): void
    {
        $this->checkAuth();
        $articleModel = new ArticleModel();
        
        $article = null;
        // On vérifie si un ID est passé dans l'URL (mode édition)
        if (isset($_GET['id'])) {
            $article = $articleModel->findById((int)$_GET['id']);
            if (!$article) {
                // Gérer le cas où l'article n'existe pas
                // header('Location: ...'); exit;
            }
        }
        
        $data = [
            'pageTitle' => $article ? 'Modifier l\'Article' : 'Nouvel Article',
            'currentPage' => 'articles',
            'article' => $article // Sera null en création, ou un tableau en édition
        ];
        
        // On rend la vue du formulaire
        $this->renderAdmin('partials/article_form', $data);
    }

    /**
     * Traite la sauvegarde (création ou mise à jour) d'un article.
     */
    public function saveArticle(): void
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . $this->baseUrl . '/index.php?page=admin-articles');
            exit;
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $articleModel = new ArticleModel();

        // 1. Récupérer et nettoyer les données du formulaire
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'image_alt' => trim($_POST['image_alt'] ?? ''),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0
        ];

        // 2. Gérer l'upload de l'image
        // Si une nouvelle image est uploadée
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../assets/images/';
            $filename = uniqid() . '-' . basename($_FILES['image']['name']);
            $uploadFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $data['image_path'] = '/assets/images/' . $filename;
            } else {
                // Gérer l'erreur d'upload
                // $_SESSION['error_message'] = "Erreur lors de l'upload de l'image.";
                // header('Location: ...'); exit;
            }
        } else {
            // Pas de nouvelle image, on garde l'ancienne en cas d'édition
            if ($id) {
                $existingArticle = $articleModel->findById($id);
                $data['image_path'] = $existingArticle['image_path'];
            } else {
                // Erreur : l'image est requise en création
                // $_SESSION['error_message'] = "Une image est requise pour créer un article.";
                // header('Location: ...'); exit;
            }
        }

        // 3. Sauvegarder en base de données
        if ($id) { // Mise à jour
            $articleModel->update($id, $data);
        } else { // Création
            $articleModel->create($data);
        }

        // 4. Rediriger vers la liste des articles
        header('Location: ' . $this->baseUrl . '/index.php?page=admin-articles');
        exit;
    }

    /**
     * Supprime un article.
     */
    public function deleteArticle(): void
    {
        $this->checkAuth();
        
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $articleModel = new ArticleModel();
            // Optionnel : supprimer aussi le fichier image du serveur
            // $article = $articleModel->findById($id);
            // if ($article && file_exists(__DIR__.'/../'.$article['image_path'])) {
            //    unlink(__DIR__.'/../'.$article['image_path']);
            // }
            $articleModel->delete($id);
        }
        
        header('Location: ' . $this->baseUrl . '/index.php?page=admin-articles');
        exit;
    }
    
    /**
     * Affiche la liste des utilisateurs (administrateurs).
     */
    public function listUsers(): void
    {
        $this->checkAuth();
        
        $userModel = new UserModel();
        
        $data = [
            'pageTitle' => 'Gestion des Utilisateurs',
            'currentPage' => 'users',
            'users' => $userModel->getAll()
        ];
        
        $this->renderAdmin('users_list', $data);
    }
    
     public function showUserForm(): void
    {
        $this->checkAuth();
        $user = null;
        if (isset($_GET['id'])) {
            $userModel = new UserModel();
            $user = $userModel->findById((int)$_GET['id']);
        }
        $this->renderAdmin('partials/user_form', ['user' => $user, 'currentPage' => 'users']);
    }

    public function saveUser(): void
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { exit; }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? null;

        $userModel = new UserModel();

        if ($id) { // Mise à jour
            // Si le champ mot de passe est vide, on passe null au modèle
            $userModel->update($id, $email, !empty($password) ? $password : null);
        } else { // Création
            if (!empty($password)) {
                $userModel->create($email, $password);
            }
        }
        header('Location: ' . $this->baseUrl . '/index.php?page=admin-users');
        exit;
    }
    
    public function deleteUser(): void
    {
        $this->checkAuth();
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $userModel = new UserModel();
            $userModel->delete($id);
        }
        header('Location: ' . $this->baseUrl . '/index.php?page=admin-users');
        exit;
    }


    /**
     * Méthode générique pour rendre une vue du back-office avec son template.
     * @param string $viewName Le nom du fichier de la vue (sans .php).
     * @param array $data Les données à passer à la vue.
     */
    protected function renderAdmin(string $viewName, array $data = []): void
    {
        $data['baseUrl'] = $this->baseUrl;
        
        // Extrait les clés du tableau en variables (ex: $data['pageTitle'] devient $pageTitle)
        extract($data);

        // Inclusion des fichiers du template admin
        require_once __DIR__ . '/../Views/admin/templates/header.php';
        require_once __DIR__ . '/../Views/admin/' . $viewName . '.php';
        require_once __DIR__ . '/../Views/admin/templates/footer.php';
    }
}