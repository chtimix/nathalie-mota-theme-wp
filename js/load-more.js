// Script pour le bouton "Charger plus" dans la galerie : écoute du clic et appel Ajax
document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('load-more');
  
    if (!loadMoreBtn) return; // le script s'arrête si le bouton n'est pas affiché (toutes les photos sont affichées)
  
    loadMoreBtn.addEventListener('click', function () {
      const button = this;
      // On récupèrer des données HTML (data-*) stockées dans le bouton “Charger plus” et on les convertit en nombres entiers utilisables en JavaScript.
      const currentPage = parseInt(button.dataset.page); // "page" actuellement chargée
      const maxPage = parseInt(button.dataset['maxPage']); // Note : les attributs data-xxx-yyy deviennent dataset.xxxYyy en camelCase automatiquement.
      const nextPage = currentPage + 1; // page qu'on veut charger maintenant
  
      button.disabled = true; // On désactive le bouton pour éviter les doubles clics.
      button.textContent = 'Chargement...'; // On change le texte pour indiquer qu’un chargement est en cours.

      // Envoi de la requête Ajax (GET) avec Fetch API
      fetch(`${nathalie_ajax.ajaxurl}?action=load_more_photos&page=${nextPage}&nonce=${nathalie_ajax.nonce}`, { // déclenche le hook wp_ajax_load_more_photos avec la page souhaitée
        method: 'GET', // On envoie les paramètres dans l’URL
        credentials: 'same-origin', // cookies de session 
      })
        .then(response => response.text()) // Traite la réponse HTML générée par PHP
        .then(data => {
          const container = document.querySelector('.gallery-container');
          container.insertAdjacentHTML('beforeend', data); // Injection du html dans le DOM à la fin du container
  
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