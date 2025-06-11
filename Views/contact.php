<main>
        <section class="section">
            <div class="container">
                <h1 class="page-title">Me contacter</h1>
                
                 <?php if ($successMessage): ?>
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 1rem; margin-bottom: 1rem; border-radius: .25rem;">
                    <?= htmlspecialchars($successMessage) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 1rem; margin-bottom: 1rem; border-radius: .25rem;">
                    <strong>Erreurs trouvées :</strong>
                    <ul>
                        <?php foreach($errors as $error): ?><li><?= htmlspecialchars($error) ?></li><?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
                <div class="contact-grid">
                    <div class="contact-text">
                        <img src="<?= $baseUrl ?>/assets/images/contact.jpg" alt="Studio photo, invitant au contact">
                        <h2>Échangeons sur Votre Projet !</h2>
                        <p>Besoin d’un mannequin détail mains pour vos projets ? Khardiata met son expérience et son savoir-faire à votre disposition. N’hésitez pas à la contacter pour en savoir plus !</p>
                    </div>

                    <form class="contact-form" action="votre_script_de_traitement.php" method="POST">
                        <div class="form-group">
                            <label for="surname">Nom</label>
                            <input type="text" id="surname" name="surname" placeholder="Votre nom de famille" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Prénom</label>
                            <input type="text" id="name" name="name" placeholder="Votre prénom" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Votre adresse email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Parlez-moi de votre projet..." required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Envoyer</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
