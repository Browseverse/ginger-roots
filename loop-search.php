<?php /* If there are no posts to display, such as an empty archive page */
global $context;
$template = $context->update(__FILE__);
echo $context->render($template);
?>
