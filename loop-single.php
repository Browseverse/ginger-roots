<?php /* Start loop */ ?>
<?php
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
// $context = new Rootache;
global $context;
$context->update();

/* getting comments */
ob_start();
comments_template();
$context->comments_template = ob_get_clean();

echo $context->render($template);
?>
