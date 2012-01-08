<?php
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
$context = new Rootache;
echo $context->render($template);
?>
