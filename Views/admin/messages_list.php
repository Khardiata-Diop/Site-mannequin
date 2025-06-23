<h1 class="page-title">Gestion des Messages</h1>

<div class="section-actions">
    <input type="search" class="search-bar" placeholder="Rechercher un message...">
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">Aucun message à afficher pour le moment.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($messages as $message): // On boucle sur $messages, chaque item devient $message ?>
                <tr>
                    <td><?= htmlspecialchars($message['id']) ?></td>
                    <td><?= htmlspecialchars($message['name'] . ' ' . $message['surname']) ?></td>
                    <td><a href="mailto:<?= htmlspecialchars($message['email']) ?>"><?= htmlspecialchars($message['email']) ?></a></td>
                    <td><?= htmlspecialchars($message['subject']) ?></td>
                    <td><?= htmlspecialchars(substr($message['message'], 0, 50)) . (strlen($message['message']) > 50 ? '...' : '') ?></td>
                    <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($message['submission_date']))) ?></td>
                    <td class="actions-cell">
                        <a href="index.php?page=view-message&id=<?= $message['id'] ?>" class="btn-icon" aria-label="Voir le message">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="index.php?page=delete-message&id=<?= $message['id'] ?>" class="btn-icon" aria-label="Supprimer le message" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>