<?php /* Start loop */ ?>
<?php 
/* template is loaded from the same filename, with extension .mustache */
$template = file_get_contents(dirname(__FILE__) . '/' . basename(__FILE__, '.php').'.mustache');

/* using the global $context, which is a Rootache object
 * calling update() on the context, to allow hooking actions to update it
 */
global $context;
$context->update();

/* Here you can add application logic, function calls or whatever you need to
 * customize your template. Then add these to the context, e.g.
 * $context->variable_name = "value"; */

echo $context->render($template);

// End the loop ?>
