<h1 class="page-title">Gestion des Utilisateurs</h1>

<div class="section-actions">
    <form action="index.php?page=admin-users" method="GET">
        <input type="hidden" name="page" value="admin-users">
        <input type="search" name="search" class="search-bar" placeholder="Rechercher un utilisateur...">
    </form>
    <a href="index.php?page=create-user" class="btn">Ajouter un utilisateur</a>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Date de création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars(date('d/m/Y', strtotime($user['created_at']))) ?></td>
                <td class="actions-cell">
                    <a href="index.php?page=edit-user&id=<?= $user['id'] ?>" class="btn-icon" aria-label="Modifier"><i class="fa-solid fa-pencil"></i></a>
                    <a href="index.php?page=delete-user&id=<?= $user['id'] ?>" class="btn-icon" aria-label="Supprimer" onclick="return confirm('Êtes-vous sûr ?');"><i class="fa-solid fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>