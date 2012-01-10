<?php

/* mustache note: 
        if you're adding an action purely to output extra stuff to the header/footer
        you might be better off converting it into a mustache partial.
        Place it inside the inc/ folder and then call it from any other mustache template
        using {{> partial_name }}
*/
add_action('roots_head', 'roots_bootstrap_head');
add_action('roots_stylesheets', 'roots_get_stylesheets');
add_action('roots_header_before', 'roots_1140_header_before');
add_action('roots_header_after', 'roots_1140_header_after');
add_action('roots_footer_before', 'roots_1140_footer_before');
add_action('roots_footer_after', 'roots_1140_footer_after');
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

function roots_get_stylesheets() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];

  $styles = '';

  switch ($roots_css_framework) {
    case 'blueprint' :
      $styles .= stylesheet_link_tag('/blueprint/screen.css');
      break;
    case '960gs_12' :
    case '960gs_16' :
      $styles .= stylesheet_link_tag('/960/reset.css');
      $styles .= stylesheet_link_tag('/960/text.css', 1);
      $styles .= stylesheet_link_tag('/960/960.css', 1);
      break;
    case '960gs_24' :
      $styles .= stylesheet_link_tag('/960/reset.css');
      $styles .= stylesheet_link_tag('/960/text.css', 1);
      $styles .= stylesheet_link_tag('/960/960_24_col.css', 1);
      break;
    case '1140' :
      $styles .= stylesheet_link_tag('/1140/1140.css');
      break;
    case 'adapt' :
      $styles .= stylesheet_link_tag('/adapt/master.css');
      $styles .= "\t<noscript>\n";
      $styles .= stylesheet_link_tag('/adapt/mobile.css', 1);
      $styles .= "\t</noscript>\n";
      break;
    case 'foundation' :
      $styles .= stylesheet_link_tag('/foundation/globals.css');
      $styles .= stylesheet_link_tag('/foundation/typography.css', 1);
      $styles .= stylesheet_link_tag('/foundation/grid.css', 1);
      $styles .= stylesheet_link_tag('/foundation/ui.css', 1);
      $styles .= stylesheet_link_tag('/foundation/forms.css', 1);
      $styles .= stylesheet_link_tag('/foundation/orbit.css', 1);
      $styles .= stylesheet_link_tag('/foundation/reveal.css', 1);
      $styles .= stylesheet_link_tag('/foundation/mobile.css', 1);
      $styles .= stylesheet_link_tag('/foundation/app.css', 1);                                          
      break;      
    case 'less' :
      $styles .= stylesheet_link_tag('/less/less.css');
      break;
    case 'bootstrap' :
      $styles .= stylesheet_link_tag('/bootstrap/bootstrap.css');
      break;
    case 'bootstrap_less' :
      $styles .= stylesheet_link_tag_boostrap_less('/bootstrap/lib/bootstrap.less');
      break;             
  }

  if (class_exists('RGForms')) {
    $styles .= "\t<link rel=\"stylesheet\" href=\"" . plugins_url(). "/gravityforms/css/forms.css\">\n";
  }

  if (is_child_theme()) {
    $styles .= stylesheet_link_tag('/style.css', 1);
    $styles .= "\t<link rel=\"stylesheet\" href=\"" . get_stylesheet_uri(). "\">\n";
  } else {
    $styles .= stylesheet_link_tag('/style.css', 1);
  }

  switch ($roots_css_framework) {
    case 'blueprint' :
      $styles .= "\t<!--[if lt IE 8]>" . stylesheet_link_tag('/blueprint/ie.css', 0, false) . "<![endif]-->\n";
      break;
    case '1140' :
      $styles .= "\t<!--[if lt IE 8]>" . stylesheet_link_tag('/1140/ie.css', 0, false) . "<![endif]-->\n";
      break;
    case 'foundation' :
      $styles .= "\t<!--[if lt IE 9]>" . stylesheet_link_tag('/foundation/ie.css', 0, false) . "<![endif]-->\n";
      break;      
  }

  echo $styles;
}

function stylesheet_link_tag($file, $tabs = 0, $newline = true) {
  $indent = str_repeat("\t", $tabs);
  return $indent . '<link rel="stylesheet" href="' . get_template_directory_uri() . '/css' . $file . '">' . ($newline ? "\n" : "");
}

function stylesheet_link_tag_boostrap_less($file, $tabs = 0, $newline = true) {
  $indent = str_repeat("\t", $tabs);
  return $indent . '<link rel="stylesheet/less" media="all" href="' . get_template_directory_uri() . '/css' . $file . '">' . ($newline ? "\n" : "");
}

function roots_1140_header_before() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === '1140') {
    echo '<div class="container"><div class="row">', "\n";
  }
}

function roots_1140_header_after() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === '1140') {
    echo "</div></div><!-- /.row /.container -->\n";
    echo '<div class="container"><div class="row">', "\n";
  }
}

function roots_1140_footer_before() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === '1140') {
    echo "</div></div><!-- /.row /.container -->\n";
    echo '<div class="container"><div class="row">', "\n";
  }
}

function roots_1140_footer_after() {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  if ($roots_css_framework === '1140') {
    echo "</div></div><!-- /.row /.container -->\n";
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
