<?php

add_action('init', function(){
    // CPT Projects
    $labels = [
        'name' => 'Проекты',
        'singular_name' => 'Проект',
    ];
    register_post_type('project', [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'project'],
        'supports' => ['title','editor','thumbnail','excerpt'],
        'show_in_rest' => false,
    ]);

    // taxonomy categories for projects
    register_taxonomy('project_category', 'project', [
        'label' => 'Категории проектов',
        'rewrite' => ['slug' => 'project-category'],
        'hierarchical' => true,
    ]);

    $terms = [
        ['name' => 'Разработка', 'slug' => 'development'],
        ['name' => 'Дизайн', 'slug' => 'design'],
        ['name' => 'Верстка', 'slug' => 'layout'],
        ['name' => 'Маркетинг', 'slug' => 'marketing'],
    ];
    foreach ($terms as $term) {
        if (!term_exists($term['name'], 'project_category')) {
            wp_insert_term(
                $term['name'],           // имя термина
                'project_category',      // таксономия
                ['slug' => $term['slug']] // слаг для URL
            );
        }
    }
});
