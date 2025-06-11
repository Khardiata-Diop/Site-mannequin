<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Khardiata, mannequin spécialisée dans le détail mains. Découvrez mon portfolio et collaborons pour sublimer vos produits.">
    <title>Accueil - Khardiata, Mannequin Mains</title>
    <link rel="icon" href="<?= $baseUrl ?>/assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css">
    
</head>
<body>
       

    <header class="main-header">
        <div class="header-container">
            <div class="logo">
                <a href="<?= $baseUrl ?>/Views/homepage.php" aria-label="Retour à la page d'accueil">
                    <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Logo de Khardiata">

                </a>
            </div>
            <nav class="desktop-nav" aria-label="Navigation principale">
                <ul>
                    <li><a href="<?= $baseUrl ?>/Views/homepage.php" class="nav-link active <?= ($currentPage === 'homepage') ? 'active' : '' ?>">Accueil</a></li>
                    <li><a href="<?= $baseUrl ?>/Views/polaroids.php" class="nav-link <?= ($currentPage === 'polaroids') ? 'active' : '' ?>">Polaroids</a></li>
                    <li><a href="<?= $baseUrl ?>/Views/mediakit.php" class="nav-link <?= ($currentPage === 'mediakit') ? 'active' : '' ?>">Kit Média</a></li>
                    <li><a href="<?= $baseUrl ?>/Views/contact.php" class="nav-link <?= ($currentPage === 'contact') ? 'active' : '' ?>">Contact</a></li>
                </ul>
            </nav>
            <button class="mobile-nav-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="Ouvrir le menu">
                <i class="fa-solid fa-bars icon-hamburger"></i>
                <i class="fa-solid fa-xmark icon-close"></i>
            </button>
        </div>
    </header>

    <nav class="mobile-nav" id="mobile-nav" aria-label="Navigation mobile">
        <ul>
            <li><a href="<?= $baseUrl ?>/Views/homepage.php" class="nav-link <?= ($currentPage === 'homepage') ? 'active' : '' ?>" >Accueil</a></li>
            <li><a href="<?= $baseUrl ?>/Views/polaroids.php" class="nav-link <?= ($currentPage === 'polaroids') ? 'active' : '' ?>">Polaroids</a></li>
            <li><a href="<?= $baseUrl ?>/Views/mediakit.php" class="nav-link <?= ($currentPage === 'mediakit') ? 'active' : '' ?>">Kit Média</a></li>
            <li><a href="<?= $baseUrl ?>/Views/contact.php" class="nav-link <?= ($currentPage === 'contact') ? 'active' : '' ?>">Contact</a></li>
        </ul>
    </nav>