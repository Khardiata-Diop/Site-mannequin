document.addEventListener('DOMContentLoaded', () => {
  // --- Script du menu mobile ---
const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
const mobileNav = document.querySelector('.mobile-nav');

mobileNavToggle.addEventListener('click', () => {
    // Affiche ou cache le menu
    mobileNav.classList.toggle('is-open');

    // Change l'icône et l'attribut aria-expanded
    const isOpen = mobileNav.classList.contains('is-open');
    mobileNavToggle.setAttribute('aria-expanded', isOpen);
    mobileNavToggle.classList.toggle('is-active');
});

//  ferme le menu en cliquant sur un lien
document.querySelectorAll('.mobile-nav a').forEach(link => {
    link.addEventListener('click', () => {
        mobileNav.classList.remove('is-open');
        mobileNavToggle.setAttribute('aria-expanded', 'false');
        mobileNavToggle.classList.remove('is-active');
    });
});

});


