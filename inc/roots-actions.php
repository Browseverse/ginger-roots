<?php

/* mustache note: 
        if you're adding an action purely to output extra stuff to the header/footer
        you might be better off converting it into a mustache partial.
        Place it inside the inc/ folder and then call it from any other mustache template
        using {{> partial_name }}

        If you need to add data to the context, you can hook to roots_mustache_context_update
        (see inc/roots-mustache-actions.php)
*/
add_action('roots_head', 'roots_bootstrap_head');

function roots_bootstrap_head() {
  /* left out this function just to deal with the mutually exclusive root options
  /*  (not sure whether this is strictly necessary though) 
  */
  global $roots_options;
  $roots_bootstrap_js = $roots_options['bootstrap_javascript'];
  $roots_bootstrap_less_js = $roots_options['bootstrap_less_javascript'];  
  if ($roots_bootstrap_js === true) {
  	$roots_options['bootstrap_less_javascript'] = false;
  }
  if ($roots_bootstrap_less_js === true) {
  	$roots_options['bootstrap_javascript'] = false;
  }  
}

?>
