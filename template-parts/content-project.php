<?php
    $main_image = get_project_main_image();
    $categories = get_the_terms(get_the_ID(), 'project_category');
    $cost = project_get_price('cost');
    $permalink = get_permalink(get_the_ID());
?>

<div class="project-card">
    <?php if ($main_image) : ?>
        <div class="project-card__thumbnail">
            <img
                src="<?php echo esc_url($main_image['url']); ?>"
                alt="<?php echo esc_attr($main_image['alt']); ?>"
                srcset="<?php echo esc_attr($main_image['srcset']); ?>"
                sizes="<?php echo esc_attr($main_image['sizes']); ?>"
            >
        </div>
    <?php endif; ?>
    
    <div class="project-card__info">
        <a href="<?php echo esc_url($permalink); ?>" class="project-card__permalink">
            <h2 class="project-title"><?php the_title(); ?></h2>
        </a>
        <?php if ($categories): ?>
        <div class="project-cats">
            <?php echo project_categories(); ?>
        </div>
        <?php endif; ?>
        <?php if ($cost): ?>
            <div class="project-price"><?php echo esc_html($cost); ?></div>
        <?php endif; ?>
    </div>

</div>
