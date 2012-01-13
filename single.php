<?php 
get_header();
global $context;
$template = $context->update(__FILE__);

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
