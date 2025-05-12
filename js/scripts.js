// Ouverture et fermeture PopUp Contact
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('.modal-contact-overlay');
    const closeBtn = document.querySelector('.modal-close');
    const openBtn = document.querySelectorAll('.open-modal-contact');
  
    openBtn.forEach(btn =>
      btn.addEventListener('click', () => {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
      })
    );
  
    closeBtn.addEventListener('click', () => {
      modal.style.display = 'none';
      document.body.style.overflow = 'auto';
    });
  });
  