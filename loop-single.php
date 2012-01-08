<?php /* Start loop */ ?>
<?php
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');
$context = new Rootache;

/* getting comments */
ob_start();
comments_template();
$context->comments_template = ob_get_clean();

echo $context->render($template);
// echo '<!--';
// print_r($template);
// print_r($cntext);
// echo '-->';
?>
