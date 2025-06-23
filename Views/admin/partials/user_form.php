<?php
$isEditing = isset($user) && $user['id'];
$formAction = 'index.php?page=save-user';
$pageTitle = $isEditing ? 'Modifier l\'Utilisateur' : 'Créer un Utilisateur';

if ($isEditing) {
    $formAction .= '&id=' . $user['id'];
}
?>

<h1 class="page-title"><?= $pageTitle ?></h1>

<form class="admin-form" action="<?= $formAction ?>" method="POST">
    
    <div class="form-group">
        <label for="email">Adresse Email</label>
        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control" <?= $isEditing ? '' : 'required' ?>>
        <?php if ($isEditing): ?>
            <p style="font-size: 0.8em; color: #666; margin-top: 5px;">Laissez ce champ vide pour ne pas modifier le mot de passe.</p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn">Enregistrer</button>
    <a href="index.php?page=admin-users" class="btn btn-secondary">Annuler</a>

</form>