<?php 
get_header();
global $context;
$template = $context->update(__FILE__);
echo $context->render($template);
get_footer();
?>
