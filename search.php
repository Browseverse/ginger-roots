<?php 
get_header();
global $context;
$template = $context->update(__FILE__);

/* getting loop-search */
ob_start();
get_template_part('loop', 'search');
$context->loop_search = ob_get_clean();
/* getting sidebar */
ob_start();
get_sidebar();
$context->sidebar = ob_get_clean();

$context->search_query = get_search_query();

echo $context->render($template);

get_footer(); 
?>
