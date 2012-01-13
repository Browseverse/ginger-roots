<?php 
global $context;
$template = $context->update(__FILE__);

/* getting language_attributes */
ob_start();
language_attributes();
$context->language_atributes = ob_get_clean();
/* getting roots_stylesheets - just in case it's still hooked onto */
ob_start();
roots_stylesheets();
$context->roots_stylesheets = ob_get_clean();
/* getting wp_head */
ob_start();
wp_head();
$context->wp_head = ob_get_clean();
/* getting roots_head - just in case it's still hooked onto */
ob_start();
roots_head();
$context->roots_head = ob_get_clean();
/* getting roots_header_before - TODO: convert to mustache partials */
ob_start();
roots_header_before();
$context->roots_header_before = ob_get_clean();

$context->have_rgforms = (class_exists('RGForms'));

$context->wp_title = wp_title('|', false, 'right');
$context->body_class = join( ' ', get_body_class( roots_body_class() ) );
$context->header_image = get_header_image();
$context->header_image_width = HEADER_IMAGE_WIDTH;
$context->header_image_height = HEADER_IMAGE_HEIGHT;
if ($roots_options['clean_menu']) {
    $context->wp_nav_menu = wp_nav_menu(array('theme_location' => 'primary_navigation', 'walker' => new roots_nav_walker(), 'echo' => false));
    $context->utility_nav_menu = wp_nav_menu(array('theme_location' => 'utility_navigation', 'walker' => new roots_nav_walker(), 'echo' => false));
} else { 
    $context->wp_nav_menu = wp_nav_menu(array('theme_location' => 'primary_navigation', 'echo' => false));
    $context->utility_nav_menu = wp_nav_menu(array('theme_location' => 'utility_navigation', 'echo' => false));
}
$utility_nav = wp_get_nav_menu_object('Utility Navigation');
$utility_nav_term_id = (int) $utility_nav->term_id;
$menu_items = wp_get_nav_menu_items($utility_nav_term_id);
$context->have_utility_menu_items = ($menu_items || !empty($menu_items));

echo $context->render($template);
?>
