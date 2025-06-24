<?php

// Dépendance vers le modèle qui gère les articles
require_once __DIR__ . '/../Models/ArticleModel.php';

class HomeController {
    /**
     * @var string L'URL de base de l'application (ex: https://khardiatadiop.sites.3wa.io/Site-mannequin)
     */
    private $baseUrl;

    /**
     * Le constructeur reçoit l'URL de base du routeur et la stocke.
     * @param string $baseUrl
     */
    public function __construct(string $baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Méthode principale pour afficher la page d'accueil.
     */
    public function index() {
        // 1. Demande les données au Modèle
        $articleModel = new ArticleModel();
        $articles = $articleModel->getActiveArticles();
        
        // 2. Prépare les données pour la Vue et appeler la méthode render
        $this->render('homepage', [
            'articles' => $articles,
            'pageTitle' => "Accueil",
            'currentPage' => "homepage"
        ]);
    }

    /**
     * Méthode générique pour rendre une vue avec son template.
     * @param string $viewName Le nom du fichier de la vue.
     * @param array $data Les données à passer à la vue.
     */
    protected function render(string $viewName, array $data = []) {
        // Ajoute l'URL de base aux données pour qu'elle soit accessible dans toutes les vues
        $data['baseUrl'] = $this->baseUrl;
        
        // Extrait les clés du tableau $data en variables (ex: $data['articles'] devient $articles)
        extract($data);

        // Inclusion des fichiers du template
        require_once __DIR__ . '/../Views/templates/header.php';
        require_once __DIR__ . '/../Views/' . $viewName . '.php';
        require_once __DIR__ . '/../Views/templates/footer.php';
    }
}