<?php

/* mustache note: 
        if you're adding an action purely to output extra stuff to the header/footer
        you might be better off converting it into a mustache partial.
        Place it inside the inc/ folder and then call it from any other mustache template
        using {{> partial_name }}
*/
add_action('roots_head', 'roots_bootstrap_head');
add_action('roots_header_before', 'roots_bootstrap_header_before');
add_action('roots_header_after', 'roots_bootstrap_header_after');
add_action('roots_footer_before', 'roots_bootstrap_footer_before');
add_action('roots_footer_after', 'roots_bootstrap_footer_after');
add_action('roots_post_inside_before', 'roots_page_breadcrumb');

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

function roots_bootstrap_header_before() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === 'bootstrap' || $roots_css_framework === 'bootstrap_less') {
    echo '<div class="container">', "\n";
  }
}

function roots_bootstrap_header_after() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === 'bootstrap' || $roots_css_framework === 'bootstrap_less') {
    echo "</div><!-- /.container -->\n";
    echo '<div class="container">', "\n";
  }
}

function roots_bootstrap_footer_before() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === 'bootstrap' || $roots_css_framework === 'bootstrap_less') {
    echo "</div><!-- /.container -->\n";
    echo '<div class="container">', "\n";
  }
}

function roots_bootstrap_footer_after() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === 'bootstrap' || $roots_css_framework === 'bootstrap_less') {
    echo "</div><!-- /.container -->\n";
  }
}

function roots_page_breadcrumb() {
  global $post;
  if (function_exists('yoast_breadcrumb')) {
    if (is_page() && $post->post_parent) {
      yoast_breadcrumb('<p id="breadcrumbs">','</p>');
    }
  }
}

?>
