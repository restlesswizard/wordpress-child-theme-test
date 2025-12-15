<?php
/**
 * Template Name: Projects Page
 */

get_header(); ?>

<section id="projects-grid" class="projects-grid">
    <div class="projects-grid__body container">
        <div class="project-grid__top">
            <h1 class="projects-grid__heading"><?php echo the_title() ?></h1>
            <div class="projects-filter">
                <div class="project-filter__body container">
                    <label for="projects-sort">Сортировать:</label>
                    <select id="projects-sort">
                        <option value="default">По умолчанию</option>
                        <option value="date-desc">По дате (сначала новые)</option>
                        <option value="date-asc">По дате (сначала старые)</option>
                        <option value="price-asc">Стоимость ↑</option>
                        <option value="price-desc">Стоимость ↓</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="projects-grid__layout">
        <?php
        // Изначальный WP_Query c аргументами
        $args = [
            'post_type' => 'project',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ];
        $projects = new WP_Query($args);

        if ($projects->have_posts()) :
            while ($projects->have_posts()) : $projects->the_post();
                get_template_part('template-parts/content', 'project'); // карточка проекта для этой страницы
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Проекты не найдены.</p>';
        endif;
        ?>
        </div>
        
    </div>
</section>

<?php get_footer(); ?>
