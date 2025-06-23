<h1 class="page-title">Détail du Message</h1>

<div class="admin-form">
    <div class="form-group">
        <strong>De :</strong>
        <p><?= htmlspecialchars($message['name'] . ' ' . $message['surname']) ?></p>
    </div>
    <div class="form-group">
        <strong>Email :</strong>
        <p><a href="mailto:<?= htmlspecialchars($message['email']) ?>"><?= htmlspecialchars($message['email']) ?></a></p>
    </div>
    <div class="form-group">
        <strong>Date de réception :</strong>
        <p><?= htmlspecialchars(date('d/m/Y à H:i', strtotime($message['submission_date']))) ?></p>
    </div>
    <div class="form-group">
        <strong>Sujet :</strong>
        <p><?= htmlspecialchars($message['subject']) ?></p>
    </div>

    <hr style="margin: 1.5rem 0; border-color: var(--admin-border-color);">

    <div class="form-group">
        <strong>Message complet :</strong>
        <div style="background-color: #f8f9fa; border: 1px solid #eee; padding: 1rem; border-radius: 8px; margin-top: 0.5rem; white-space: pre-wrap; line-height: 1.6;">
            <?= htmlspecialchars($message['message']) ?>
        </div>
    </div>
    
    <div style="margin-top: 2rem;">
        <a href="index.php?page=admin-messages" class="btn btn-secondary">Retour à la liste</a>
    </div>
</div>