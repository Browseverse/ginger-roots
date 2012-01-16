<?php
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
        $this->_partials = new MustacheLoader(get_template_directory() . '/templates');
        $this->init();
        $this->is_page = is_page(); // must be used outside the loop
    }

    public function init() {
        /* init function is used to (re)-initialize the 'standard'
         * wordpress variables. This is particularly important from within the loop !
         *
         * Note that if you override any of those values 
         * and you use them within the loop, then these values will be
         * reset back every loop iteration!
         */
        global $post, $wp_query;
        $this->the_ID = get_the_ID();
        $this->post_class = join( ' ', get_post_class());
        $this->post_parent = $post->post_parent;
        $this->is_singular = is_singular();
        $this->is_archive = is_archive();
        $this->is_search = is_search();
        $this->is_page = ($post->post_type == 'page'); // different check inside the loop
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
        $this->if_have_posts = in_the_loop() || have_posts(); /* safe way of calling have_posts without altering state (?) */
        $this->template_directory_uri = get_template_directory_uri();
        $this->stylesheet_uri = get_stylesheet_uri();
        $this->plugins_url = plugins_url();
        $this->roots_options = roots_get_theme_options();

        /* which framework? */
        $roots_css_framework = $this->roots_options['css_framework'];
        $this->framework_960gs_12 = ($roots_css_framework === '960gs_12');
        $this->framework_960gs_16 = ($roots_css_framework === '960gs_16');
        $this->framework_960gs_24 = ($roots_css_framework === '960gs_24');
        $this->framework_1140 = ($roots_css_framework === '1140');
        $this->framework_adapt = ($roots_css_framework === 'adapt');
        $this->framework_bootstrap_less = ($roots_css_framework === 'bootstrap_less');
        $this->framework_bootstrap = ($roots_css_framework === 'bootstrap');
        $this->framework_blueprint = ($roots_css_framework === 'blueprint');
        $this->framework_foundation = ($roots_css_framework === 'foundation');
        $this->framework_less = ($roots_css_framework === 'less');

        /* TODO: these methods should also move to a mustache template / partials */
        $this->previous_posts_link = get_previous_posts_link( __( '&larr; Older posts', 'roots' ) );
        $this->next_posts_link = get_next_posts_link( __( 'Newer posts &rarr;', 'roots' ) );
        $this->page_navigation = wp_link_pages(array('before' => '<nav id="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>', 'echo' => 0 ));
    }

    /* update performs several key tasks:
     *
     * - loads the template based on the php filename
     * - allows adding data to the context. Simply hook to 'roots_mustache_context_update' action
     *   and use the global $context variable
     * - updates context variables outside the loop
     * - returns the loaded :template
     * @access public
     * @param string $php_filename (default: null)
     * @return string Mustache template (unrendered).
     */
    public function update($php_filename = null) {
        if ($php_filename !== null) {
            $this->_template = file_get_contents(dirname($php_filename) . '/templates/' . basename($php_filename, '.php').'.mustache');
        }

        $this->is_page = is_page(); // must be used outside the loop
        $this->if_have_posts = in_the_loop() || have_posts(); /* safe way of calling have_posts without altering state (?) */
        do_action('roots_mustache_context_update');

        return $this->_template;
    }

    /* lambda functions */
    public function the_loop() { return array($this, '_the_loop'); }
    public function get_the_time() { return array($this, '_get_the_time'); }
    public function get_the_date() { return array($this, '_get_the_date'); }
    public function __() { return array($this, 'translate'); }

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
    public static function _get_the_date($str) { return get_the_date($str); }


    /* Translates strings with embedded tags (normally translated using %s placeholders)
     * e.g. :   {{#__}}Hello World{{/__}}
     *          {{#__}}Hello {{something}}{{/__}}
     *          {{#__}} Time: {{#get_the_time}}c{{/get_the_time}} {{/__}}
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
$context = new Rootache;
$GLOBALS['context'] = $context;
?>
