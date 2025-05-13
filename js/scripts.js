// Ouverture et fermeture PopUp Contact
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('.modal-contact-overlay');
    const closeBtn = document.querySelector('.modal-close');
    const openBtn = document.querySelectorAll('.open-modal-contact');
  
    openBtn.forEach(btn =>
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        modal.classList.add('visible'); // affichage immédiat
        requestAnimationFrame(() => { // petite pause pour permettre à l'affichage de s'effectuer
          modal.classList.add('active'); // déclenche le fondu CSS
          document.body.style.overflow = 'hidden';
        });
      })
    );
  
    closeBtn.addEventListener('click', () => {
      modal.classList.remove('active'); // démarre le fade-out
      document.body.style.overflow = 'auto';
  
      // attendre la fin de la transition avant de cacher
      setTimeout(() => {
        modal.classList.remove('visible'); // repasse display: none
      }, 300); // même durée que la transition CSS
    });
  });
  