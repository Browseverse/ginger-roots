<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
global $context;
$context->update();
$context->is_archive_or_search = ( is_archive() || is_search() );
echo $context->render($template);
?>
