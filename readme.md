# 📸 Nathalie Mota – Thème WordPress personnalisé

Ce thème WordPress a été conçu pour le site de la photographe Nathalie Mota. Il est entièrement développé sur mesure en utilisant les fonctionnalités avancées de WordPress : CPT, taxonomies personnalisées, SASS, API REST et Ajax.

---

## 🔧 Fonctionnalités principales

- **CPT Photo** : avec image mise en avant, champ ACF, et taxonomies personnalisées
- **Page d'accueil dynamique** : chargement des photos via l'API REST
- **Filtres dynamiques** : filtres par catégorie, format, tri par date ou titre
- **Pagination Ajax** : bouton "Charger plus" basé sur l'API REST
- **Lightbox photo** : affichage en plein écran
- **Modale de contact** : formulaire intégré avec Contact Form 7
- **Optimisation** : filemtime() pour le cache busting, structure JS modulaire

---

## 📂 Arborescence simplifiée

```
wp-content/
└── themes/
    └── nathaliemota/
        ├── assets/
        │   ├── css/
        │   │   └── style.css
        │   ├── scss/
        │   │   └── style.scss (source sass)
        │   ├── js/
        │   │   ├── main.js
        │   │   ├── gallery.js
        │   │   ├── modal-contact.js
        │   │   ├── lightbox.js
        │   │   └── photo-preview.js
        ├── inc/
        │   ├── cpt-photo.php
        │   └── rest-api.php
        ├── template_parts/
        │   └── lightbox.php
        │   └── photo-bloc.php
        ├── functions.php
        ├── style.css
        └── ...
```

---

## 🧩 API REST personnalisée

### Endpoint
```
GET /wp-json/nathalie/v1/photos
```

### Paramètres possibles
| Paramètre   | Type   | Valeurs possibles                   | Par défaut |
|-------------|--------|-------------------------------------|------------|
| `page`      | entier | Numéro de page                      | 1          |
| `categorie` | string | Slug d’une catégorie (taxonomy)     | ''         |
| `format`    | string | `paysage` ou `portrait`             | ''         |
| `order`     | string | `date_asc`, `date_desc`             | ''         |

### Réponse JSON
```json
{
  "html": "<div class=\"photo\">...</div>",
  "max_pages": 4,
  "current_page": 2
}
```

---

## 🚀 Pour démarrer en local

1. Cloner le dépôt dans le dossier `wp-content/themes`
2. Lancer Local ou XAMPP
3. Activer le thème "Nathalie Mota" depuis l’admin WP
4. Aller dans Réglages > Permaliens et enregistrer
5. S’assurer que les images sont publiées dans le CPT `photo`
6. Visiter la page d’accueil

---

## ✏️ Développement

- Utilise `style.scss` comme fichier source, compilé vers `assets/css/style.css`
- JS modulaire : un fichier par fonctionnalité UI
- Requêtes Ajax via l’API REST uniquement (pas `admin-ajax.php`)

---

## 🚚 Mise en ligne (production)

1. **Finaliser le site localement** (vérifier maquettes, contenus, navigation, responsive)
2. Installer l’extension **WP Migrate Lite** pour exporter la base de données
3. Remplacer l’URL locale par le nom de domaine live (ex. `motaphoto.com`)
4. Exporter une archive ZIP contenant :
   - Tous les fichiers du thème `nathaliemota`
   - La base de données exportée
5. Importer le thème et la base de données sur le serveur distant
6. Activer le thème sur le WordPress en ligne
7. Réinitialiser les permaliens depuis le back-office
8. Tester l’ensemble du site (modale, filtres, chargement Ajax, lightbox)

🔐 **Pense-bête sécurité** :
- Vérifier que `WP_DEBUG` est désactivé
- Installer un plugin de sécurité de base (Wordfence, etc.)
- Activer un certificat SSL

---

## 📄 Licence

Projet réalisé dans le cadre d’une formation. Code réutilisable à des fins pédagogiques ou personnelles.

---

## 👨‍💻 Auteur
Développé par [Ton Nom ou pseudo], 2025
