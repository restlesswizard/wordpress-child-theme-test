<?php
// AJAX handler
add_action('wp_ajax_filter_projects', 'filter_projects_ajax'); // авторизованные пользователи
add_action('wp_ajax_nopriv_filter_projects', 'filter_projects_ajax'); // неавторизованные пользователи

function filter_projects_ajax() {
    // Сортировка
    $sort = sanitize_text_field($_POST['sort'] ?? 'default');

    // Формируем аргументы запроса
    $args = [
        'post_type' => 'project',
        'posts_per_page' => -1,
    ];

    // Параметры сортировки
    switch ($sort) {
        case 'date-asc':
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
            break;
        case 'date-desc':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'price-asc':
            $args['meta_key'] = 'cost';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'price-desc':
            $args['meta_key'] = 'cost';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        default:
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
    }

    $projects = new WP_Query($args); // формируем запрос

    ob_start(); // включаем буфер для сбора HTML из get_template_part в строку, т.к. нам нужна строка, а функция выведет HTML напрямую без этого
    if ($projects->have_posts()) :
        while ($projects->have_posts()) : $projects->the_post();
            get_template_part('template-parts/content', 'project');
        endwhile;
        wp_reset_postdata(); // сбрасываем
    else :
        echo '<p>Проекты не найдены.</p>'; // фоллбек
    endif;

    // Насколько я знаю, после этого WordPress уже вызывает wp_die()
    wp_send_json([
        'html' => ob_get_clean(),
    ]);

    // Но напишем его на всякий случай
    wp_die();
}