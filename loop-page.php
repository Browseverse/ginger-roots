<?php /* Start loop */ ?>
<?php //while (have_posts()) : the_post(); 

//include_once('Mustache.php');
/* template is loaded from the same filename, with extension .mustache */
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');


$context = new Rootache;
/* Here you can add application logic, function calls or whatever you need to
 * customize your template. Then add these to the context, e.g.
 * $context->variable_name = "value"; */

//$m = new Mustache;
echo $context->render($template);
//echo the_content();

//endwhile; // End the loop ?>
