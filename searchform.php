<?php
global $context;
$template = $context->update(__FILE__);
echo $context->render($template);
?>
