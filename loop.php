<?php /* If there are no posts to display, such as an empty archive page */
global $context;
$template = $context->update(__FILE__);
$context->is_archive_or_search = ( is_archive() || is_search() );
echo $context->render($template);
?>
