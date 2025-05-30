// ============================================
// Fichier : menu-mobile.js
// Rôle : Gère le menu mobile et le bouton hamburger
// ============================================

document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('menu-toggle');      // bouton hamburger
    const menu = document.getElementById('mobile-menu');        // menu déroulant
    const links = document.querySelectorAll('.menu__list a');   // tous les liens du menu
  
    // Au clic sur le hamburger, bascule les classes actives
    toggle.addEventListener('click', function () {
      toggle.classList.toggle('is-active');     // transforme le hamburger en croix
      menu.classList.toggle('is-visible');      // affiche ou cache le menu mobile
      document.body.classList.toggle('no-scroll'); // Bloque/débloque le scroll de la page
    });
  
    // Fermer le menu automatiquement quand on clique sur un lien
    links.forEach(link => {
      link.addEventListener('click', () => {
        toggle.classList.remove('is-active');
        menu.classList.remove('is-visible');
        document.body.classList.remove('no-scroll');
      });
    });
  });