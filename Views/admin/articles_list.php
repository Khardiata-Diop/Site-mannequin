<h1 class="page-title">Gestion des Articles</h1>

<div class="section-actions">
     <input type="search" class="search-bar" placeholder="Rechercher un article...">
    <a href="index.php?page=create-article" class="btn">Ajouter un article</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Ordre</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= htmlspecialchars($article['id']) ?></td>
                <td><img src="<?= $baseUrl . htmlspecialchars($article['image_path']) ?>" alt="" style="width: 80px; height: 80px; object-fit: cover;"></td>
                <td><?= htmlspecialchars($article['title']) ?></td>
                <td><?= htmlspecialchars($article['display_order']) ?></td>
                <td><?= $article['is_active'] ? 'Oui' : 'Non' ?></td>
                <td class="actions-cell">
                    <a href="index.php?page=edit-article&id=<?= $article['id'] ?>" class="btn-icon" aria-label="Modifier"><i class="fa-solid fa-pencil"></i></a>
                    <a href="index.php?page=delete-article&id=<?= $article['id'] ?>" class="btn-icon" aria-label="Supprimer" onclick="return confirm('Êtes-vous sûr ?');"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>