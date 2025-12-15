<?php
/**
 * Получает и форматирует цену из ACF-поля типа Number, добавляя при необходимости единицу измерения (например, ₽).
 * 
 * Особенности:
 * - Работает только внутри The Loop или при явной передаче $post_id.
 * - Если поле пустое или не найдено — возвращает null.
 * - Форматирует число через пробелы (например: 12000 → "12 000").
 * - Добавляет значение 'append' из настроек поля ACF (например, "₽").
 * Пример использования:
 * // Внутри цикла
 * echo project_get_price('cost');
 * // С указанием конкретного поста
 * echo project_get_price('cost', 123);
 *
 * @param string $field_name  Слаг ACF-поля (например, 'cost')
 * @param int|string|null $post_id  ID поста. Если null — используется get_the_ID()
 * @return string|null  Отформатированная цена с единицей измерения или null
 */
function project_get_price($field_name = 'cost', $post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    if (!$post_id) {
        return null; // пост не определён
    }

    $field = get_field_object($field_name, $post_id);

    if (!$field || !isset($field['value'])) {
        return null;
    }

    $value = $field['value'];
    $append = $field['append'] ?? '';

    $formatted = number_format((float) $value, 0, ',', ' ');

    return trim($formatted . ' ' . $append);
}



/**
 * Возвращает inline-style для hero-блока с затемнением и фоновым изображением.
 * Пример использования:
 * <div class="hero-block" <?php echo project_hero_bg_style(); ?>>
 *     <h1>Заголовок проекта</h1>
 * </div>
 *
 * @param int|null $post_id
 * @return string  Например: style="position:relative; background: ...;"
 */
function project_hero_bg_style($post_id = null) {

    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $thumb_url = get_the_post_thumbnail_url($post_id, 'full');

    if (!$thumb_url) {
        // пустой стиль если нет миниатюры
        return 'style="position:relative; height:80vh; min-height:750px;"';
    }

    // Экранируем URL
    $thumb_url = esc_url($thumb_url);

    // Собираем CSS
    $style = "
        position: relative;
        height: 85vh;
        min-height: 860px;
        background: linear-gradient(
            90deg,
            rgba(0,0,0,0.85) 0%,
            rgba(0,0,0,0.65) 35%,
            rgba(0,0,0,0.15) 65%,
            transparent 100%
        ),
        url('{$thumb_url}') center/cover no-repeat;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    ";

    // Убираем переносы и лишние пробелы
    $style = preg_replace('/\s+/', ' ', trim($style));

    return 'style="' . esc_attr($style) . '"';
}


/**
 * Возвращает HTML категорий для текущего проекта
 *
 * Пример использования:
 * echo project_categories(); // выводит категории текущего проекта
 * echo project_categories(123); // вывод категорий проекта с ID 123
 * @param int|null $post_id ID поста (по умолчанию текущий)
 * @return string HTML
 */
function project_categories($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $terms = get_the_terms($post_id, 'project_category');
    if (!$terms || is_wp_error($terms)) {
        return '';
    }

    $html = '<div class="project-cat">';
    foreach ($terms as $term) {
        $link = esc_url(get_term_link($term));
        $name = esc_html($term->name);
        $slug = esc_html($term->slug);
        $html .= '<div class="project-cat__item '. $slug. '"><a href="' . $link . '">' . $name . '</a></div>';
    }
    $html .= '</div>';

    return $html;
}


/**
 * Возвращает массив изображений галереи проекта
 *
 * Пример использования:
 * $gallery = get_project_gallery_images(); // массив изображений текущего проекта
 * foreach ($gallery as $image) {
 *     echo '<img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'">';
 * }
 * @param int|null $post_id ID поста (по умолчанию текущий)
 * @param string $field_name Имя ACF поля (по умолчанию 'gallery')
 * @return array
 */
function get_project_gallery_images($post_id = null, $field_name = 'gallery') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $gallery = get_field($field_name, $post_id);
    $images = [];

    if (is_array($gallery)) {
        foreach ($gallery as $key => $value) {
            if (strpos($key, 'image_') !== false && $value) {
                // URL изображения full
                $url = wp_get_attachment_image_url($value, 'full');
                if (!$url) continue;

                // Alt
                $alt = get_post_meta($value, '_wp_attachment_image_alt', true);
                if (!$alt) $alt = get_the_title($post_id);

                // Srcset и sizes
                $srcset = wp_get_attachment_image_srcset($value, 'full');
                $sizes  = wp_get_attachment_image_sizes($value, 'full');

                $images[] = [
                    'url' => $url,
                    'alt' => $alt,
                    'srcset' => $srcset,
                    'sizes' => $sizes,
                ];
            }
        }
    }

    return $images;
}


/**
 * Возвращает главный объект изображения проекта
 *
 * Пример использования
 * $main_image = get_project_main_image();
 * if ($main_image) {
 *     echo '<img src="'.esc_url($main_image['url']).'" alt="'.esc_attr($main_image['alt']).'">';
 * }
 * @param int|null $post_id
 * @return array|null
 */
function get_project_main_image($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    // Сначала пост-тамбнейл
    $thumb_id = get_post_thumbnail_id($post_id);

    if ($thumb_id) {
        $url = wp_get_attachment_image_url($thumb_id, 'full');
        $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
        if (!$alt) $alt = get_the_title($post_id);
        $srcset = wp_get_attachment_image_srcset($thumb_id, 'full');
        $sizes  = wp_get_attachment_image_sizes($thumb_id, 'full');

        return [
            'url' => $url,
            'alt' => $alt,
            'srcset' => $srcset,
            'sizes' => $sizes,
        ];
    }

    // fallback — первая картинка из галереи
    $gallery = get_project_gallery_images($post_id);
    return $gallery[0] ?? null;
}