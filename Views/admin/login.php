<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Connexion' ?></title>
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/admin.css">
    <link rel="icon" href="<?= $baseUrl ?>/assets/images/logo.png">
</head>
<body class="login-page">

    <main>
        <div class="login-card">
            <a href="index.php?page=homepage" target="_blank" title="Voir le site public">
            <img src="<?= $baseUrl ?>/assets/images/logo.png" alt="Logo Khardiata" class="logo">
            </a>
            <h1>Système d'administration</h1>

            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="index.php?page=login-submit" method="POST">
                <div class="form-group">
                    <label for="email">Votre e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Votre mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn">Se connecter</button>
            </form>
        </div>
    </main>

</body>
</html>