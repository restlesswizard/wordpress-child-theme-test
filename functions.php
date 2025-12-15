<?php

// Для упрощения построения путей
define('THEME_URI', get_template_directory_uri());
define('THEME_PATH', get_template_directory());

define('THEME_URI_CHILD', get_stylesheet_directory_uri());
define('THEME_PATH_CHILD', get_stylesheet_directory());

define('THEME_CSS', THEME_URI_CHILD  . '/assets/css');
define('THEME_JS', THEME_URI_CHILD  . '/assets/js');
define('THEME_INC', THEME_PATH_CHILD  . '/inc');

define('THEME_LIB', THEME_INC . '/lib');


// Удаляем лишнее
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);


// include регистрация CPT + таксономии
require_once THEME_INC . '/post-types.php';
require_once THEME_INC . '/enqueue.php';
require_once THEME_INC . '/helpers.php';
require_once THEME_INC . '/ajax-handlers.php';



