<?php
/**
 * Plugin Name: Up Gutenberg Binding Collection
 * Description: Collection de 20 sources de binding pour l'API Block Bindings de WordPress 6.5+. Permet de lier dynamiquement le contenu des blocs Gutenberg aux données du site (posts, taxonomies, custom fields, etc.) sans code.
 * Version: 1.0.0
 * Author: UP
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Text Domain: up
 */

// 1. PERMALIEN (déjà créé)
register_block_bindings_source('up/permalink', array(
    'label' => __('Permalien', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        return $post_id ? get_permalink($post_id) : '';
    },
    'uses_context' => array('postId'),
));

// 2. TITRE DU SITE
register_block_bindings_source('up/site-title', array(
    'label' => __('Titre du site', 'up'),
    'get_value_callback' => function() {
        return get_bloginfo('name');
    },
));

// 3. DESCRIPTION DU SITE
register_block_bindings_source('up/site-description', array(
    'label' => __('Description du site', 'up'),
    'get_value_callback' => function() {
        return get_bloginfo('description');
    },
));

// 4. ANNÉE COURANTE (pour copyright)
register_block_bindings_source('up/current-year', array(
    'label' => __('Année courante', 'up'),
    'get_value_callback' => function() {
        return date('Y');
    },
));

// 5. NOM DE L'AUTEUR
register_block_bindings_source('up/author-name', array(
    'label' => __('Nom de l\'auteur', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $author_id = get_post_field('post_author', $post_id);
        return get_the_author_meta('display_name', $author_id);
    },
    'uses_context' => array('postId'),
));

// 6. LIEN ARCHIVE AUTEUR
register_block_bindings_source('up/author-url', array(
    'label' => __('URL auteur', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $author_id = get_post_field('post_author', $post_id);
        return get_author_posts_url($author_id);
    },
    'uses_context' => array('postId'),
));

// 7. DATE DE PUBLICATION (format personnalisé)
register_block_bindings_source('up/post-date', array(
    'label' => __('Date de publication', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $format = $source_args['format'] ?? 'j F Y'; // ex: 15 janvier 2024
        return get_the_date($format, $post_id);
    },
    'uses_context' => array('postId'),
));

// 8. TEMPS DE LECTURE ESTIMÉ
register_block_bindings_source('up/reading-time', array(
    'label' => __('Temps de lecture', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $content = get_post_field('post_content', $post_id);
        $word_count = str_word_count(strip_tags($content));
        $minutes = ceil($word_count / 200); // 200 mots par minute
        return sprintf(__('%d min de lecture', 'up'), $minutes);
    },
    'uses_context' => array('postId'),
));

// 9. NOMBRE DE COMMENTAIRES
register_block_bindings_source('up/comments-count', array(
    'label' => __('Nombre de commentaires', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '0';
        return get_comments_number($post_id);
    },
    'uses_context' => array('postId'),
));

// 10. CATÉGORIE PRINCIPALE
register_block_bindings_source('up/primary-category', array(
    'label' => __('Catégorie principale', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $categories = get_the_category($post_id);
        return !empty($categories) ? $categories[0]->name : '';
    },
    'uses_context' => array('postId'),
));

// 11. LIEN CATÉGORIE PRINCIPALE
register_block_bindings_source('up/primary-category-url', array(
    'label' => __('URL catégorie principale', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $categories = get_the_category($post_id);
        return !empty($categories) ? get_category_link($categories[0]->term_id) : '';
    },
    'uses_context' => array('postId'),
));

// 12. EXTRAIT PERSONNALISÉ
register_block_bindings_source('up/excerpt', array(
    'label' => __('Extrait', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $length = $source_args['length'] ?? 55; // Nombre de mots
        return wp_trim_words(get_the_excerpt($post_id), $length);
    },
    'uses_context' => array('postId'),
));

// 13. URL IMAGE À LA UNE
register_block_bindings_source('up/featured-image-url', array(
    'label' => __('URL image à la une', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $size = $source_args['size'] ?? 'full';
        return get_the_post_thumbnail_url($post_id, $size);
    },
    'uses_context' => array('postId'),
));

// 14. CUSTOM FIELD (ACF ou meta)
register_block_bindings_source('up/custom-field', array(
    'label' => __('Champ personnalisé', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id || empty($source_args['key'])) return '';
        
        // Supporte ACF
        if (function_exists('get_field')) {
            return get_field($source_args['key'], $post_id);
        }
        
        // Fallback sur get_post_meta
        return get_post_meta($post_id, $source_args['key'], true);
    },
    'uses_context' => array('postId'),
));

// 15. URL DU LOGO
register_block_bindings_source('up/site-logo-url', array(
    'label' => __('URL du logo', 'up'),
    'get_value_callback' => function() {
        $custom_logo_id = get_theme_mod('custom_logo');
        return $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : '';
    },
));

// 16. EMAIL DU SITE
register_block_bindings_source('up/admin-email', array(
    'label' => __('Email admin', 'up'),
    'get_value_callback' => function() {
        return get_option('admin_email');
    },
));

// 17. NOMBRE TOTAL D'ARTICLES
register_block_bindings_source('up/posts-count', array(
    'label' => __('Nombre d\'articles', 'up'),
    'get_value_callback' => function($source_args) {
        $post_type = $source_args['post_type'] ?? 'post';
        $count = wp_count_posts($post_type);
        return $count->publish ?? 0;
    },
));

// 18. TITRE DE LA PAGE PARENTE
register_block_bindings_source('up/parent-title', array(
    'label' => __('Titre page parente', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $parent_id = wp_get_post_parent_id($post_id);
        return $parent_id ? get_the_title($parent_id) : '';
    },
    'uses_context' => array('postId'),
));

// 19. URL PAGE PARENTE
register_block_bindings_source('up/parent-url', array(
    'label' => __('URL page parente', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id) return '';
        $parent_id = wp_get_post_parent_id($post_id);
        return $parent_id ? get_permalink($parent_id) : '';
    },
    'uses_context' => array('postId'),
));

// 20. TERME TAXONOMY CUSTOM
register_block_bindings_source('up/taxonomy-term', array(
    'label' => __('Terme taxonomy', 'up'),
    'get_value_callback' => function($source_args, $block_instance) {
        $post_id = $block_instance->context['postId'] ?? get_the_ID();
        if (!$post_id || empty($source_args['taxonomy'])) return '';
        
        $terms = get_the_terms($post_id, $source_args['taxonomy']);
        if (!$terms || is_wp_error($terms)) return '';
        
        return $terms[0]->name;
    },
    'uses_context' => array('postId'),
));

// Enregistrer tous les bindings
function up_register_all_bindings() {
    // Le code ci-dessus s'exécute automatiquement
}
add_action('init', 'up_register_all_bindings');

/**
 * EXEMPLES D'UTILISATION :
 * 
 * 1. Copyright dynamique :
 * <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/current-year"}}}} -->
 * <p>© 2024 Mon Site</p>
 * <!-- /wp:paragraph -->
 * 
 * 2. Bouton vers la catégorie :
 * <!-- wp:button {"metadata":{"bindings":{"url":{"source":"up/primary-category-url"},"text":{"source":"up/primary-category"}}}} -->
 * 
 * 3. Temps de lecture :
 * <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/reading-time"}}}} -->
 * <p>5 min de lecture</p>
 * <!-- /wp:paragraph -->
 * 
 * 4. Custom field avec paramètre :
 * <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/custom-field","args":{"key":"telephone"}}}}} -->
 * <p>Téléphone</p>
 * <!-- /wp:paragraph -->
 * 
 * 5. Date formatée :
 * <!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"up/post-date","args":{"format":"d/m/Y"}}}}} -->
 * <p>01/01/2024</p>
 * <!-- /wp:paragraph -->
 */