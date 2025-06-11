<main>
        <section class="section">
            <div class="container">
                
                <h1 class="page-title home-hero-title">Khardiata, mannequin détail mains</h1>

                <div class="home-intro-grid">
                    <?php if (!empty($articles)): ?>
                    <?php foreach ($articles as $article): ?>
                        <article class="intro-card">
                            <img src="<?= $baseUrl . htmlspecialchars($article['image_path']) ?>" alt="<?= htmlspecialchars($article['image_alt']) ?>">
                            <h3><?= htmlspecialchars($article['title']) ?></h3>
                            <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
