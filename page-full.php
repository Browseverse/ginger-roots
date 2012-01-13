<?php
/*
Template Name: Full Width
*/
get_header();
global $context;
$template = $context->update(__FILE__);

/* getting loop-index */
ob_start();
get_template_part('loop', 'page');
$context->loop_page = ob_get_clean();

echo $context->render($template);

get_footer(); ?>
