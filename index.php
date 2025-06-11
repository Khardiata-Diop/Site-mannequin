<?php

session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// On récupère l'URL de base depuis le .env
$baseUrl = $_ENV['APP_URL'];

/**
 * Rend une vue statique avec son template.
 * On passe maintenant $baseUrl en paramètre.
 */
function render_static_page(string $viewName, string $pageTitle, string $currentPage, string $baseUrl): void {
    extract(['pageTitle' => $pageTitle, 'currentPage' => $currentPage, 'baseUrl' => $baseUrl]);
    require_once __DIR__ . '/Views/templates/header.php';
    require_once __DIR__ . '/Views/' . $viewName . '.php';
    require_once __DIR__ . '/Views/templates/footer.php';
}

// Charger les contrôleurs
require_once __DIR__ . '/Controllers/HomeController.php';
require_once __DIR__ . '/Controllers/ContactController.php';

// On passe $baseUrl aux constructeurs des contrôleurs
$homeController = new HomeController($baseUrl);
$contactController = new ContactController($baseUrl);

$page = $_GET['page'] ?? 'homepage';

switch ($page) {
    case 'homepage':
        $homeController->index();
        break;

    case 'contact':
        $contactController->index();
        break;

    case 'contact-submit':
        $contactController->submit();
        break;

    case 'polaroids':
        render_static_page('polaroids', 'Polaroids', 'polaroids', $baseUrl);
        break;

    case 'mediakit':
        render_static_page('mediakit', 'Kit Média', 'mediakit', $baseUrl);
        break;
        
    default:
        http_response_code(404);
        render_static_page('404', 'Page non trouvée', '404', $baseUrl);
        break;
}