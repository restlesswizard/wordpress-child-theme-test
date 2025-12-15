<?php

add_action('wp_enqueue_scripts', function() {
    // Общее
    wp_enqueue_style('child-style', THEME_URI_CHILD . '/style.css');
    wp_enqueue_style('responsive', THEME_CSS . '/responsive.css', [], filemtime(THEME_PATH_CHILD . '/assets/css/responsive.css'));
    // single-project
    if (is_singular('project')) {
        wp_enqueue_script(
            'embla-carousel',
            THEME_URI_CHILD . '/inc/lib/embla-carousel.umd.js',
            [],
            null,
            true
        );

        wp_enqueue_script(
            'project-gallery',
            THEME_URI_CHILD . '/assets/js/project-gallery.js',
            ['embla-carousel'],
            filemtime(THEME_PATH_CHILD . '/assets/js/project-gallery.js'),
            true
        );

        wp_enqueue_style(
            'lightbox2-css',
            'https://cdn.jsdelivr.net/npm/lightbox2@2.11.5/dist/css/lightbox.min.css',
            [],
            '2.11.5'
        );

        wp_enqueue_script(
            'lightbox2-js',
            'https://cdn.jsdelivr.net/npm/lightbox2@2.11.5/dist/js/lightbox.min.js',
            ['jquery'],
            '2.11.5',
            true
        );
    }
    // page-projects
    if (is_page('projects')) {
        wp_enqueue_script(
            'projects-filter',
            THEME_URI_CHILD . '/assets/js/projects-filter.js',
            ['jquery'],
            filemtime(THEME_PATH_CHILD . '/assets/js/projects-filter.js'),
            true
        );

        wp_localize_script('projects-filter', 'ajaxurl', admin_url('admin-ajax.php'));
    }






});




