<?php
// On détermine si on est en mode édition ou création
$isEditing = isset($article) && $article['id'];
$formAction = 'index.php?page=save-article';
$pageTitle = $isEditing ? 'Modifier l\'Article' : 'Créer un Article';

// Si on est en édition, on ajoute l'ID à l'action du formulaire
if ($isEditing) {
    $formAction .= '&id=' . $article['id'];
}
?>

<h1 class="page-title"><?= $pageTitle ?></h1>

<form class="admin-form" action="<?= $formAction ?>" method="POST" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($article['title'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="content">Contenu</label>
        <textarea id="content" name="content" class="form-control" rows="5" required><?= htmlspecialchars($article['content'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="image">Image</label>
        <input type="file" id="image" name="image" class="form-control" <?= $isEditing ? '' : 'required' ?>>
        <?php if ($isEditing && !empty($article['image_path'])): ?>
            <p>Image actuelle :</p>
            <img src="<?= $baseUrl . htmlspecialchars($article['image_path']) ?>" alt="Aperçu" style="max-width: 200px; margin-top: 10px;">
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label for="image_alt">Texte alternatif de l'image (ALT)</label>
        <input type="text" id="image_alt" name="image_alt" class="form-control" value="<?= htmlspecialchars($article['image_alt'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="display_order">Ordre d'affichage</label>
        <input type="number" id="display_order" name="display_order" class="form-control" value="<?= htmlspecialchars($article['display_order'] ?? '0') ?>" required>
    </div>

    <div class="form-group form-check">
        <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1" <?= (isset($article['is_active']) && $article['is_active']) ? 'checked' : '' ?>>
        <label for="is_active" class="form-check-label">Rendre l'article visible sur le site ?</label>
    </div>

    <button type="submit" class="btn">Enregistrer</button>
    <a href="index.php?page=admin-articles" class="btn btn-secondary">Annuler</a>

</form>