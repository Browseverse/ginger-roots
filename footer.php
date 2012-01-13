<?php 
global $context;
$template = $context->update(__FILE__);

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
