<?php /* Start loop */
/* using the global $context, which is a Rootache object
 * calling update() on the context, specifying this filename so it loads the template and returns it
 * update() also allows hooking actions to update it, and performs some out of the loop updates
 */
global $context;
$template = $context->update(__FILE__);

/* Here you can add application logic, function calls or whatever you need to
 * customize your template. Then add these to the context, e.g.
 * $context->variable_name = "value"; */

echo $context->render($template);

// End the loop ?>
