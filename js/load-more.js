// Script pour le bouton "Charger plus" dans la galerie : écoute du clic et appel Ajax
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('load-more');
  
    if (!loadMoreBtn) return;
  
    loadMoreBtn.addEventListener('click', function () {
      const button = this;
      const currentPage = parseInt(button.dataset.page);
      const maxPage = parseInt(button.dataset['maxPage']);
      const nextPage = currentPage + 1;
  
      button.disabled = true;
      button.textContent = 'Chargement...';
  
      fetch(`${ajaxurl}?action=load_more_photos&page=${nextPage}`, {
        method: 'GET',
        credentials: 'same-origin',
      })
        .then(response => response.text())
        .then(data => {
          const container = document.querySelector('.gallery-container');
          container.insertAdjacentHTML('beforeend', data);
  
          button.dataset.page = nextPage;
          button.disabled = false;
          button.textContent = 'Charger plus';
  
          if (nextPage >= maxPage) {
            button.style.display = 'none';
          }
        })
        .catch(error => {
          console.error('Erreur lors du chargement :', error);
          button.disabled = false;
          button.textContent = 'Charger plus';
        });
    });
  });