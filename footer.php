<?php 
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
global $context;
$context->update();

/* getting sidebar */
ob_start();
dynamic_sidebar('roots-footer');
$context->footer_sidebar = ob_get_clean();

/* getting wp footer */
ob_start();
wp_footer();
$context->wp_footer = ob_get_clean();

/* getting roots footer */
ob_start();
roots_footer();
$context->roots_footer = ob_get_clean();

$context->current_year = date('Y');
echo $context->render($template);
?>
