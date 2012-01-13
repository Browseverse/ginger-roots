<?php
get_header();
global $context;
$template = $context->update(__FILE__);

/* getting loop-category */
ob_start();
get_template_part('loop', 'category');
$context->loop_category = ob_get_clean();
/* getting sidebar */
ob_start();
get_sidebar();
$context->sidebar = ob_get_clean();

$context->is_day = is_day();
$context->is_month = is_month();
$context->is_year = is_year();
$context->is_author = is_author();

if ( !(is_author() || is_year() || is_month() || is_day()) ) {
    $context->single_cat_title = single_cat_title("", false);
}
$author_id = $post->post_author;
$context->author_name = get_the_author_meta('user_nicename', $author_id);

echo $context->render($template);

get_footer(); 
?>
