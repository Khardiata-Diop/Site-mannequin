<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Administration' ?> - Khardiata</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/admin.css">
    <link rel="icon" href="<?= $baseUrl ?>/assets/images/logo.png">
</head>
<body>

    <div class="admin-wrapper">
        <header class="admin-header">
            <a href="index.php?page=homepage" target="_blank" title="Voir le site public">
                <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Logo" class="logo">
            </a>

            <nav class="desktop-nav">
                <a href="index.php?page=dashboard" class="<?= ($currentPage === 'dashboard') ? 'active' : '' ?>">Accueil</a>
                <a href="index.php?page=admin-users" class="<?= ($currentPage === 'users') ? 'active' : '' ?>">Utilisateurs</a>
                <a href="index.php?page=admin-messages" class="<?= ($currentPage === 'messages') ? 'active' : '' ?>">Messages</a>
                <a href="index.php?page=admin-articles" class="<?= ($currentPage === 'articles') ? 'active' : '' ?>">Articles</a>
            </nav>

            <div class="admin-user">
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user_email'] ?? 'Admin') ?> !</span>
                <a href="index.php?page=logout" class="logout-btn" aria-label="Se déconnecter">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>

            <button class="mobile-nav-toggle" aria-controls="mobile-nav" aria-expanded="false">
                <i class="fa-solid fa-bars icon-hamburger"></i>
                <i class="fa-solid fa-xmark icon-close"></i>
            </button>
        </header>

        <nav class="mobile-nav" id="mobile-nav">
            <ul>
                <li><a href="index.php?page=dashboard" class="<?= ($currentPage === 'dashboard') ? 'active' : '' ?>">Accueil</a></li>
                <li><a href="index.php?page=admin-users" class="<?= ($currentPage === 'users') ? 'active' : '' ?>">Utilisateurs</a></li>
                <li><a href="index.php?page=admin-messages" class="<?= ($currentPage === 'messages') ? 'active' : '' ?>">Messages</a></li>
                <li><a href="index.php?page=admin-articles" class="<?= ($currentPage === 'articles') ? 'active' : '' ?>">Articles</a></li>
                <li><a href="index.php?page=logout">Se déconnecter</a></li>
            </ul>
        </nav>

        <main class="admin-main">