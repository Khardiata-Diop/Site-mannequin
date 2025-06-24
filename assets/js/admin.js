/*
  Gère les interactions JavaScript pour le panneau d'administration.
 */
document.addEventListener('DOMContentLoaded', () => {

    // --- Script du menu mobile de l'administration ---
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const mobileNav = document.querySelector('.mobile-nav');

    // On vérifie que les éléments existent avant d'ajouter des écouteurs
    // pour éviter les erreurs sur la page de login qui n'a pas ce menu.
    if (mobileNavToggle && mobileNav) {
        
        mobileNavToggle.addEventListener('click', () => {
            // Affiche ou cache le menu en ajoutant/retirant la classe 'is-open'
            mobileNav.classList.toggle('is-open');

            // Change l'icône (hamburger/croix) en ajoutant/retirant la classe 'is-active' sur le bouton
            mobileNavToggle.classList.toggle('is-active');

            // Met à jour l'attribut aria-expanded pour l'accessibilité
            const isOpen = mobileNav.classList.contains('is-open');
            mobileNavToggle.setAttribute('aria-expanded', isOpen);
        });

        // --- Amélioration : Fermer le menu en cliquant sur un lien ---
        // C'est utile pour que le menu se ferme automatiquement après une navigation.
        const navLinks = mobileNav.querySelectorAll('a');
        
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileNav.classList.remove('is-open');
                mobileNavToggle.classList.remove('is-active');
                mobileNavToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

});