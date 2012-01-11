<?php // https://github.com/retlehs/roots/wiki

if (!defined('__DIR__')) define('__DIR__', dirname(__FILE__));

require_once locate_template('/inc/roots-activation.php');  // activation
require_once locate_template('/inc/roots-options.php');     // theme options
require_once locate_template('/inc/roots-cleanup.php');     // cleanup
require_once locate_template('/inc/roots-htaccess.php');    // rewrites for assets, h5bp htaccess
require_once locate_template('/inc/roots-hooks.php');       // hooks
require_once locate_template('/inc/roots-actions.php');     // actions
require_once locate_template('/inc/roots-widgets.php');     // widgets
require_once locate_template('/inc/roots-custom.php');      // custom functions

$roots_options = roots_get_theme_options();

// set the maximum 'Large' image width to the maximum grid width
// http://wordpress.stackexchange.com/q/11766
if (!isset($content_width)) {
  global $roots_options;
  $roots_css_framework = $roots_options['css_framework'];
  switch ($roots_css_framework) {
      case 'blueprint':   $content_width = 950;   break;
      case '960gs_12':    $content_width = 940;   break;
      case '960gs_16':    $content_width = 940;   break;
      case '960gs_24':    $content_width = 940;   break;
      case '1140':        $content_width = 1140;  break;
      case 'adapt':       $content_width = 940;   break;
      case 'bootstrap':   $content_width = 940;   break;
      case 'foundation':  $content_width = 980;   break;
      default:            $content_width = 950;   break;
  }
}

function roots_setup() {
  load_theme_textdomain('roots', get_template_directory() . '/lang');

  // tell the TinyMCE editor to use editor-style.css
  // if you have issues with getting the editor to show your changes then
  // use this instead: add_editor_style('editor-style.css?' . time());
  add_editor_style('editor-style.css');

  // http://codex.wordpress.org/Post_Thumbnails
  add_theme_support('post-thumbnails');
  // set_post_thumbnail_size(150, 150, false);

  // http://codex.wordpress.org/Post_Formats
  // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

  // http://codex.wordpress.org/Function_Reference/add_custom_image_header
  if (!defined('HEADER_TEXTCOLOR')) { define('HEADER_TEXTCOLOR', ''); }
  if (!defined('NO_HEADER_TEXT')) { define('NO_HEADER_TEXT', true); }
  if (!defined('HEADER_IMAGE')) { define('HEADER_IMAGE', get_template_directory_uri() . '/img/logo.png'); }
  if (!defined('HEADER_IMAGE_WIDTH')) { define('HEADER_IMAGE_WIDTH', 300); }
  if (!defined('HEADER_IMAGE_HEIGHT')) { define('HEADER_IMAGE_HEIGHT', 75); }

  function roots_custom_image_header_site() { }
  function roots_custom_image_header_admin() { ?>
    <style type="text/css">
      .appearance_page_custom-header #headimg { min-height: 0; }
    </style>
  <?php }
  add_custom_image_header('roots_custom_image_header_site', 'roots_custom_image_header_admin');

  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'roots'),
    'utility_navigation' => __('Utility Navigation', 'roots')
  ));
}

add_action('after_setup_theme', 'roots_setup');

// http://codex.wordpress.org/Function_Reference/register_sidebar
// hook into 'widgets_init' function with a lower priority in your
// child theme to remove these sidebars
function roots_register_sidebars() {
  register_sidebar(
    array(
      'id'=> 'roots-sidebar',
      'name' => __('Sidebar', 'roots'),
      'description' => __('Sidebar', 'roots'),
      'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="container">',
      'after_widget' => '</div></article>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
    ));
  register_sidebar(
    array(
      'id'=> 'roots-footer',
      'name' => __('Footer', 'roots'),
      'description' => __('Footer', 'roots'),
      'before_widget' => '<article id="%1$s" class="widget %2$s"><div class="container">',
      'after_widget' => '</div></article>',
      'before_title' => '<h3>',
      'after_title' => '</h3>'
    ));
}

add_action('widgets_init', 'roots_register_sidebars');

require_once('Mustache.php');
require_once('MustacheLoader.php');

/* Rootache is a Mustache helper class for roots.
 *
 * It supports several standard wp methods as well as:
 *  - translations using {{#__}} {{/__}} tags
 *  - partials (include other templates) using {{> }} tag
 */
class Rootache extends Mustache {
    function __construct() {
        parent::__construct();
        /* auto loading partials */
        $this->_partials = new MustacheLoader(dirname(__FILE__) . '/inc');
        $this::init();
    }

    public function init() {
        /* init function is used to (re)-initialize the 'standard'
         * wordpress variables. This is particularly import from within the loop !
         *
         * Note that if you override any of those values 
         * and you use them within the loop, then these values will be
         * reset back every loop iteration!
         */
        global $wp_query;
        $this->the_ID = get_the_ID();
        $this->post_class = join( ' ', get_post_class());
        $this->is_singular = is_singular();
        $this->is_archive = is_archive();
        $this->is_search = is_search();
        $this->is_user_logged_in = is_user_logged_in();
        $this->is_child_theme = is_child_theme();
        $this->the_permalink = get_permalink();
        $this->the_title = get_the_title();
        $this->the_content = apply_filters('the_content', get_the_content());
        $this->the_excerpt= apply_filters('the_excerpt', get_the_excerpt());
        $this->home_url = home_url();
        $this->author_posts_url = get_author_posts_url(get_the_author_meta('id'));
        $this->the_author = get_the_author();
        $this->more_pages = ($wp_query->max_num_pages > 1);
        $this->the_tags = get_the_tag_list('', ', ', ''); /* todo: might want to break this down to array of tags and handle in mustache template */
        $this->bloginfo['name'] = get_bloginfo('name');
        $this->siteurl = get_option('siteurl');
        $this->do_have_posts = !in_the_loop() && have_posts(); /* safe way of calling have_posts without altering state (?) */
        $this->template_directory_uri = get_template_directory_uri();
        $this->stylesheet_uri = get_stylesheet_uri();
        $this->plugins_url = plugins_url();
        $this->roots_options = roots_get_theme_options();

        /* TODO: these methods should also move to a mustache template / partials */
        $this->previous_posts_link = get_previous_posts_link( __( '&larr; Older posts', 'roots' ) );
        $this->next_posts_link = get_next_posts_link( __( 'Newer posts &rarr;', 'roots' ) );
        $this->page_navigation = wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>', 'echo' => 0 ));
    }
    public function __()
    {
        return array('Rootache', 'translate');
    }

    public function _the_loop($str) { 
        $ret = ""; 
        while ( have_posts() ) : 
            the_post(); 
            //$me = new Rootache; 
            $this->init();
            $ret .= $this->render($str); 
        endwhile; 
        return $ret; 
    }

    public static function _get_the_time($str) { return get_the_time($str); }

    public function the_loop() { return array('Rootache', '_the_loop'); }
    public function get_the_time() { return array('Rootache', '_get_the_time'); }

    /* Translates strings with embedded tags (normally translated using %s placeholders)
     * e.g. :   {{#__}}Hello World{{/__}}
     *          {{#__}}Hello {{something}}{{/__}}
     *          {{#__}} Date: {{#get_the_time}}c{{/get_the_time}} {{/__}}
     */
    public function translate($str) {
        /* Finding sections within the template (e.g. {{#something}}text{{/something}}
         *  Those need to be constructed and replaced first
         *  storing matches into $section_matches (so we can swap them back)
         */
        $template = $str;
        $section_matches = array();
		while ($section = $this->_findSection($template)) {
            list($before, $type, $tag_name, $content, $after) = $section;
            $section_text = '{{' . $type . $tag_name . '}}' . $content . '{{/' . $tag_name . '}}';
            array_push($section_matches, $section_text);
            $str = __(str_replace($section_text, '%s', $str), 'roots');
            $template = $after;
        }
        // searching for all standard {{tags}} in the string
        $matches = array();
        if ( preg_match_all('/{{\s*.*?\s*}}/', $str, &$matches) ) {
            // first we remove ALL tags and replace with %s and retrieve the translated version
            $str = __(preg_replace('/{{\s*.*?\s*}}/', '%s', $str), 'roots'); 
        }
        // then replace %s back to {{tag}} or sections with the matches
        if ( $tags = array_merge($matches[0], $section_matches) ) { 
            return vsprintf($str, $tags);
        } 
        else
            return __($str, 'roots');
    }
}

?>
