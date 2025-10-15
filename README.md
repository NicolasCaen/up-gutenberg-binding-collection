# Up Gutenberg Binding Collection

Collection complète de 20 sources de binding pour l'API Block Bindings de WordPress 6.5+.

## Description

Ce plugin permet de lier dynamiquement le contenu des blocs Gutenberg aux données WordPress (posts, taxonomies, custom fields, options du site, etc.) **sans écrire de code**. Utilisez simplement l'éditeur de blocs pour connecter vos blocs à des sources de données dynamiques.

## Prérequis

- WordPress 6.5 ou supérieur
- PHP 7.4 ou supérieur

## Installation

1. Téléchargez ou clonez ce dépôt dans `/wp-content/plugins/`
2. Activez le plugin depuis l'administration WordPress
3. Les 20 sources de binding sont immédiatement disponibles dans l'éditeur de blocs

## Sources de Binding Disponibles

### 🔗 Liens & Navigation

#### `up/permalink`
**Usage :** Lien vers l'article/page actuel  
**Blocs compatibles :** Button (url), Image (url)  
**Exemple :**
```html
<!-- wp:button {"metadata":{"bindings":{"url":{"source":"up/permalink"}}}} -->
```

#### `up/author-url`
**Usage :** Lien vers la page archive de l'auteur  
**Blocs compatibles :** Button (url), Image (url)

#### `up/primary-category-url`
**Usage :** Lien vers la catégorie principale de l'article  
**Blocs compatibles :** Button (url), Image (url)

#### `up/parent-url`
**Usage :** Lien vers la page parente  
**Blocs compatibles :** Button (url), Image (url)

---

### 📝 Contenu de l'Article

#### `up/author-name`
**Usage :** Nom d'affichage de l'auteur  
**Blocs compatibles :** Paragraph, Heading, Button (text)  
**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/author-name"}}}} -->
<p>Auteur</p>
<!-- /wp:paragraph -->
```

#### `up/post-date`
**Usage :** Date de publication avec format personnalisable  
**Blocs compatibles :** Paragraph, Heading  
**Arguments :**
- `format` : Format PHP de date (défaut: `j F Y`)

**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/post-date","args":{"format":"d/m/Y"}}}}} -->
<p>15/10/2025</p>
<!-- /wp:paragraph -->
```

#### `up/reading-time`
**Usage :** Temps de lecture estimé (basé sur 200 mots/min)  
**Blocs compatibles :** Paragraph, Heading  
**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/reading-time"}}}} -->
<p>5 min de lecture</p>
<!-- /wp:paragraph -->
```

#### `up/comments-count`
**Usage :** Nombre de commentaires  
**Blocs compatibles :** Paragraph, Heading

#### `up/primary-category`
**Usage :** Nom de la catégorie principale  
**Blocs compatibles :** Paragraph, Heading, Button (text)

#### `up/excerpt`
**Usage :** Extrait de l'article avec longueur personnalisable  
**Arguments :**
- `length` : Nombre de mots (défaut: 55)

**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/excerpt","args":{"length":30}}}}} -->
<p>Extrait court...</p>
<!-- /wp:paragraph -->
```

#### `up/featured-image-url`
**Usage :** URL de l'image à la une  
**Blocs compatibles :** Image (url)  
**Arguments :**
- `size` : Taille d'image WordPress (défaut: `full`)

**Exemple :**
```html
<!-- wp:image {"metadata":{"bindings":{"url":{"source":"up/featured-image-url","args":{"size":"large"}}}}} -->
```

---

### 🏢 Informations du Site

#### `up/site-title`
**Usage :** Nom du site  
**Blocs compatibles :** Paragraph, Heading  
**Exemple :**
```html
<!-- wp:heading {"metadata":{"bindings":{"content":{"source":"up/site-title"}}}} -->
<h1>Mon Site</h1>
<!-- /wp:heading -->
```

#### `up/site-description`
**Usage :** Slogan du site  
**Blocs compatibles :** Paragraph, Heading

#### `up/current-year`
**Usage :** Année courante (pour copyright dynamique)  
**Blocs compatibles :** Paragraph, Heading  
**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/current-year"}}}} -->
<p>© 2025 Mon Site</p>
<!-- /wp:paragraph -->
```

#### `up/site-logo-url`
**Usage :** URL du logo du site (défini dans le Customizer)  
**Blocs compatibles :** Image (url)

#### `up/admin-email`
**Usage :** Email administrateur du site  
**Blocs compatibles :** Paragraph

---

### 📊 Statistiques & Compteurs

#### `up/posts-count`
**Usage :** Nombre total d'articles publiés  
**Arguments :**
- `post_type` : Type de contenu (défaut: `post`)

**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/posts-count","args":{"post_type":"product"}}}}} -->
<p>150 produits</p>
<!-- /wp:paragraph -->
```

---

### 🔧 Champs Personnalisés

#### `up/custom-field`
**Usage :** Valeur d'un champ personnalisé (ACF ou meta)  
**Arguments :**
- `key` : Nom du champ (requis)

**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/custom-field","args":{"key":"telephone"}}}}} -->
<p>01 23 45 67 89</p>
<!-- /wp:paragraph -->
```

**Note :** Compatible avec ACF (Advanced Custom Fields) si installé.

---

### 📂 Hiérarchie & Taxonomies

#### `up/parent-title`
**Usage :** Titre de la page parente  
**Blocs compatibles :** Paragraph, Heading, Button (text)

#### `up/taxonomy-term`
**Usage :** Premier terme d'une taxonomie custom  
**Arguments :**
- `taxonomy` : Slug de la taxonomie (requis)

**Exemple :**
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/taxonomy-term","args":{"taxonomy":"product_cat"}}}}} -->
<p>Électronique</p>
<!-- /wp:paragraph -->
```

---

## Exemples d'Utilisation Pratiques

### 1. Copyright Dynamique dans le Footer
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/current-year"}}}} -->
<p>© 2025 Mon Site - Tous droits réservés</p>
<!-- /wp:paragraph -->
```

### 2. Bouton "Lire la Suite" Dynamique
```html
<!-- wp:button {"metadata":{"bindings":{"url":{"source":"up/permalink"},"text":{"source":"up/primary-category"}}}} -->
<div class="wp-block-button">
    <a class="wp-block-button__link">Catégorie</a>
</div>
<!-- /wp:button -->
```

### 3. Carte d'Article avec Métadonnées
```html
<!-- wp:group -->
    <!-- wp:heading {"metadata":{"bindings":{"content":{"source":"core/post-title"}}}} /-->
    
    <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/author-name"}}}} -->
    <p>Par Auteur</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/post-date","args":{"format":"j F Y"}}}}} -->
    <p>15 octobre 2025</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/reading-time"}}}} -->
    <p>5 min de lecture</p>
    <!-- /wp:paragraph -->
    
    <!-- wp:button {"metadata":{"bindings":{"url":{"source":"up/permalink"}}}} -->
    <div class="wp-block-button">
        <a class="wp-block-button__link">Lire l'article</a>
    </div>
    <!-- /wp:button -->
<!-- /wp:group -->
```

### 4. Affichage d'un Numéro de Téléphone (Custom Field)
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/custom-field","args":{"key":"telephone"}}}}} -->
<p>Téléphone : 01 23 45 67 89</p>
<!-- /wp:paragraph -->
```

### 5. Statistiques du Site
```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/posts-count"}}}} -->
<p>150 articles publiés</p>
<!-- /wp:paragraph -->
```

---

## Comment Utiliser les Bindings

### Méthode 1 : Via l'Éditeur de Code (recommandé)

1. Créez votre bloc (Paragraph, Button, etc.)
2. Cliquez sur les trois points ⋮ → **Modifier en HTML**
3. Ajoutez l'attribut `metadata` avec la source de binding :

```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/author-name"}}}} -->
<p>Texte par défaut</p>
<!-- /wp:paragraph -->
```

### Méthode 2 : Via le Code du Template

Ajoutez directement dans vos templates de blocs :

```php
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/site-title"}}}} -->
<p><?php bloginfo('name'); ?></p>
<!-- /wp:paragraph -->
```

---

## Blocs Compatibles

| Bloc | Attributs bindables |
|------|---------------------|
| **Paragraph** | `content` |
| **Heading** | `content` |
| **Button** | `text`, `url` |
| **Image** | `url`, `alt` |

---

## Notes Techniques

### Contexte Post
La plupart des sources utilisent le contexte `postId` pour récupérer les données. Elles fonctionnent :
- Dans les Query Loops
- Dans les templates de post
- Sur les pages d'archive

### Performances
Toutes les fonctions utilisent les API WordPress natives et sont optimisées pour la mise en cache.

### Compatibilité ACF
La source `up/custom-field` détecte automatiquement ACF et utilise `get_field()` si disponible.

---

## Support & Contribution

Pour signaler un bug ou proposer une amélioration, ouvrez une issue sur le dépôt GitHub.

---

## Changelog

### 1.0.0
- Version initiale
- 20 sources de binding disponibles
- Support WordPress 6.5+

---

## Licence

Ce plugin est distribué sous licence GPL v2 ou ultérieure.
