/* *
 * Ouverture et fermeture PopUp Contact
 * */

document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('.modal-contact-overlay');
    const closeBtn = document.querySelector('.modal-close');
    const openBtns = document.querySelectorAll('.open-modal-contact');
  
    openBtns.forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        const ref = this.getAttribute('data-ref');
        const photoRefInput = document.querySelector('#photo-ref');
  
        // Récupère la référence de la photo
        photoRefInput.value = ref;
        photoRefInput.disabled = true;
        // Ouvre la modale
        modal.classList.add('visible');
        requestAnimationFrame(() => {
          modal.classList.add('active');
          document.body.style.overflow = 'hidden';
        });
      });
    });
  
    closeBtn.addEventListener('click', () => {
      modal.classList.remove('active');
      document.body.style.overflow = 'auto';
      setTimeout(() => {
        modal.classList.remove('visible');
      }, 300);
    });
  });