<?php /* Start loop */
global $context;
$template = $context->update(__FILE__);

/* getting comments */
ob_start();
comments_template();
$context->comments_template = ob_get_clean();

echo $context->render($template);
?>
