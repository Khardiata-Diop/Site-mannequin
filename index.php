<?php

/**
 * Démarre ou reprend une session utilisateur existante.
 * Ceci est nécessaire pour utiliser la superglobale $_SESSION, 
 * par exemple pour stocker des messages de statut ou des informations sur l'utilisateur connecté.
 */
session_start();

/**
 * Charge l'autoloader de Composer.
 * Ce fichier, généré par Composer, permet de charger automatiquement les classes des dépendances du projet
 * (comme Dotenv ici) sans avoir besoin de faire des `require_once` manuels pour chaque classe.
 * __DIR__ est une constante magique qui retourne le répertoire du fichier actuel.
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Crée une instance de Dotenv.
 * `createImmutable` signifie que les variables chargées depuis le fichier .env NE surchargeront PAS
 * les variables d'environnement déjà existantes sur le serveur. C'est une pratique de sécurité.
 * Le paramètre `__DIR__` indique que le fichier `.env` doit être cherché à la racine du projet.
 * @var Dotenv\Dotenv $dotenv
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

/**
 * Charge les variables d'environnement depuis le fichier .env.
 * Les variables définies dans ce fichier (ex: APP_URL, DB_HOST) sont maintenant accessibles
 * via les superglobales `$_ENV` et `$_SERVER`.
 */
$dotenv->load();

/**
 * Récupère l'URL de base de l'application depuis les variables d'environnement.
 * Cette variable sera utilisée pour construire des URLs absolues dans les vues (liens, images, etc.),
 * ce qui rend l'application plus portable entre différents environnements (local, production).
 * @var string $baseUrl L'URL de base de l'application.
 */
$baseUrl = $_ENV['APP_URL'];

/**
 * Rend une vue statique en assemblant un en-tête, le contenu de la vue et un pied de page.
 * Cette fonction factorise le code de rendu pour les pages qui n'ont pas de logique complexe
 * et qui n'ont donc pas besoin d'un contrôleur dédié.
 *
 * @param string $viewName    Le nom du fichier de la vue (sans l'extension .php) à inclure.
 * @param string $pageTitle   Le titre de la page, utilisé dans la balise <title> de l'en-tête.
 * @param string $currentPage Un identifiant pour la page actuelle, utile pour la navigation (ex: marquer le lien actif).
 * @param string $baseUrl     L'URL de base de l'application, à passer aux vues pour construire les liens.
 * @return void               Cette fonction ne retourne rien, elle affiche directement le contenu HTML.
 */
function render_static_page(string $viewName, string $pageTitle, string $currentPage, string $baseUrl): void {
    /**
     * Crée des variables locales (`$pageTitle`, `$currentPage`, `$baseUrl`) à partir du tableau associatif.
     * Ces variables seront alors directement accessibles dans les fichiers de vue inclus ci-dessous.
     */
    extract(['pageTitle' => $pageTitle, 'currentPage' => $currentPage, 'baseUrl' => $baseUrl]);

    /**
     * Inclut le fichier d'en-tête commun à toutes les pages.
     * Ce fichier contient généralement le doctype, la balise <head>, et le début du <body>.
     */
    require_once __DIR__ . '/Views/templates/header.php';

    /**
     * Inclut le fichier de vue spécifique à la page demandée.
     * Le nom du fichier est construit dynamiquement à partir du paramètre `$viewName`.
     */
    require_once __DIR__ . '/Views/' . $viewName . '.php';

    /**
     * Inclut le fichier de pied de page commun.
     * Ce fichier contient généralement la fin du <body>, la balise </html> et les scripts JS.
     */
    require_once __DIR__ . '/Views/templates/footer.php';
}

/**
 * Charge les fichiers des contrôleurs nécessaires pour l'application.
 * Dans une application plus complexe, un autoloader PSR-4 serait configuré pour gérer cela automatiquement.
 */
require_once __DIR__ . '/Controllers/HomeController.php';
require_once __DIR__ . '/Controllers/ContactController.php';
require_once __DIR__ . '/Controllers/AdminController.php';

/**
 * Instancie les contrôleurs.
 * On passe `$baseUrl` au constructeur de chaque contrôleur. C'est une forme d'injection de dépendances :
 * le contrôleur reçoit ses dépendances (ici, l'URL de base) à sa création,
 * plutôt que de les chercher lui-même dans des variables globales.
 * @var HomeController $homeController
 * @var ContactController $contactController
 */
$homeController = new HomeController($baseUrl);
$contactController = new ContactController($baseUrl);
$adminController = new AdminController($baseUrl);

/**
 * Détermine la page à afficher en se basant sur le paramètre 'page' dans l'URL (ex: index.php?page=contact).
 * L'opérateur de coalescence nulle (`??`) assigne la valeur 'homepage' par défaut si le paramètre `$_GET['page']` n'existe pas.
 * @var string $page La page demandée par l'utilisateur.
 */
$page = $_GET['page'] ?? 'homepage';

/**
 * Structure de contrôle (routeur) qui aiguille la requête vers l'action appropriée
 * en fonction de la valeur de la variable `$page`.
 */
switch ($page) {
    /**
     * Cas pour la page d'accueil.
     */
    case 'homepage':
        /**
         * Appelle la méthode `index` du `HomeController` qui gère la logique et l'affichage de la page d'accueil.
         */
        $homeController->index();
        break;

    /**
     * Cas pour la page de contact (affichage du formulaire).
     */
    case 'contact':
        /**
         * Appelle la méthode `index` du `ContactController` qui gère l'affichage du formulaire de contact.
         */
        $contactController->index();
        break;

    /**
     * Cas pour le traitement de la soumission du formulaire de contact.
     */
    case 'contact-submit':
        /**
         * Appelle la méthode `submit` du `ContactController` qui traite les données du formulaire.
         */
        $contactController->submit();
        break;

    /**
     * Cas pour la page statique "Polaroids".
     */
    case 'polaroids':
        /**
         * Appelle directement la fonction `render_static_page` car cette page n'a pas de logique métier complexe.
         */
        render_static_page('polaroids', 'Polaroids', 'polaroids', $baseUrl);
        break;

    /**
     * Cas pour la page statique "Kit Média".
     */
    case 'mediakit':
        /**
         * Appelle également la fonction `render_static_page`.
         */
        render_static_page('mediakit', 'Kit Média', 'mediakit', $baseUrl);
        break;
        
    // --- ROUTES BACK-OFFICE ---

    // -- Connexion / Déconnexion --
    case 'login':
        $adminController->showLoginPage();
        break;
    
    case 'login-submit':
        $adminController->handleLogin();
        break;

    case 'logout':
        $adminController->logout();
        break;

    // -- Dashboard --
    case 'dashboard':
        $adminController->showDashboard();
        break;

    // -- CRUD Articles --
    case 'admin-articles': // READ (List)
        $adminController->listArticles();
        break;
    
    case 'create-article': // CREATE 
        $adminController->showArticleForm();
        break;
        
    case 'edit-article': // UPDATE 
        $adminController->showArticleForm();
        break;

    case 'save-article': // CREATE & UPDATE 
        $adminController->saveArticle();
        break;

    case 'delete-article': // DELETE 
        $adminController->deleteArticle();
        break;
    
    // -- CRUD Messages --
    case 'admin-messages': // READ (List)
        $adminController->listMessages();
        break;
    
    case 'view-message': // READ (Single)
        $adminController->showMessage(); 
        break;
        
    case 'delete-message': // DELETE 
        $adminController->deleteMessage(); 
        break;

    // -- CRUD Utilisateurs --
    case 'admin-users': // READ 
        $adminController->listUsers();
        break;
        
    case 'create-user': // CREATE 
        $adminController->showUserForm(); 
        break;
        
    case 'edit-user': // UPDATE 
        $adminController->showUserForm(); 
        break;
        
    case 'save-user': // CREATE & UPDATE 
        $adminController->saveUser(); 
        break;
        
    case 'delete-user': // DELETE 
        $adminController->deleteUser(); 
        break;

        
    /**
     * Cas par défaut, exécuté si la valeur de `$page` ne correspond à aucune route définie.
     */
    default:
        /**
         * Définit le code de statut de la réponse HTTP à 404 (Not Found).
         * C'est sémantiquement correct et important pour le référencement (SEO) et les outils de monitoring.
         */
        http_response_code(404);

        /**
         * Affiche une page d'erreur 404 personnalisée en utilisant la même fonction de rendu.
         */
        render_static_page('404', 'Page non trouvée', '404', $baseUrl);
        break;
}