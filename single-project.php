<?php
/**
 * Template Name: Single Project Page
 */

get_header();

$thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
$price = project_get_price('cost');
$developing_time = get_field('developing_time');
$additional_description = get_field('additional_description');
$images = get_project_gallery_images();
$fields = get_field_objects(get_the_ID());

?>

<article class="project">
    <div class="wrapper project__wrapper">
        <div class="project__body">
            <div class="project__hero" <?= project_hero_bg_style(); ?>>
                <div class="project-info container">
                    <div class="project-info__card">
                        <h1 class="project-info__title"><?php the_title(); ?></h1>
                        <?php echo project_categories(); ?>
                        <div class="project-meta">
                            <div class="project-meta__body">
                                <div class="project-meta__card">
                                    <div class="project-meta__heading">
                                        Стоимость
                                    </div>
                                    <?php if ($price): ?>
                                    <div class="project-meta__data">
                                        <?php echo esc_html($price); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($developing_time): ?>
                                <div class="project-meta__card">
                                    <div class="project-meta__heading">
                                        Время разработки
                                    </div>
                                    <div class="project-meta__data">
                                        <?php echo esc_html($developing_time); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="project-info__content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($additional_description): ?>
            <section class="project-desc-add">
                <div class="project-desc-add__body container">
                    <?php echo wp_kses_post($additional_description, array()) ?>
                </div>
            </section>
            <?php endif; ?>
            <?php if (!empty($images)) : ?>
                <section class="project-gallery">
                    <div class="project-gallery__body container">
                        <h2 class="project-gallery__heading">Галерея</h2>
                        <div class="embla">
                            <div class="embla__viewport">
                                <div class="embla__container">
                                    <?php foreach ($images as $img): ?>
                                        <div class="embla__slide">
                                            <a href="<?php echo esc_url($img['url']); ?>" data-lightbox="project-gallery" data-title="<?php echo esc_attr($img['alt']); ?>">
                                                <img
                                                    class="embla__slide-img"
                                                    src="<?php echo esc_url($img['url']); ?>"
                                                    alt="<?php echo esc_attr($img['alt']); ?>"
                                                    srcset="<?php echo esc_attr($img['srcset']); ?>"
                                                    sizes="<?php echo esc_attr($img['sizes']); ?>"
                                                >
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <button class="embla__prev" aria-label="Previous slide">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 18L9 12L15 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <button class="embla__next" aria-label="Next slide">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 6L15 12L9 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php get_footer(); ?>