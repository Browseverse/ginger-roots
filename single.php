<?php 
get_header();
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
global $context;
$context->update();

/* getting loop-single */
ob_start();
get_template_part('loop', 'single');
$context->loop_single = ob_get_clean();
/* getting sidebar */
ob_start();
get_sidebar();
$context->sidebar = ob_get_clean();

echo $context->render($template);

get_footer(); 
?>
