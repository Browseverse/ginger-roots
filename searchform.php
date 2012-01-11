<?php
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
global $context;
$context->update();
echo $context->render($template);
?>
