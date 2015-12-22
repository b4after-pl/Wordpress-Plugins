<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Elastic_Slide
 * @subpackage Elastic_Slide/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Elastic_Slide
 * @subpackage Elastic_Slide/public
 * @author     Your Name <email@example.com>
 */
class Elastic_Slide_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $Elastic_Slide    The ID of this plugin.
     */
    private $Elastic_Slide;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $Elastic_Slide       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($Elastic_Slide = "Elastic_Slide_scripts", $version) {

        $this->Elastic_Slide = $Elastic_Slide;
        $this->version = $version;
        $this->Active_Marker = $this->elastic_slider_active_check();
    }
    
    /**
     * Check is plugin turned on for public or for admin (preview)
     * 
     * @since 1.0.0
     */
    private function elastic_slider_active_check()
    {
        $control = false;
        if(get_option('elastic_slider_admin_active') && is_super_admin()) { 
            $control = true;
        } elseif(get_option('elastic_slider_active')) { 
            if(!$this->elastic_slider_cookie_check()) { $control = true; }
        }
        return $control;
    }
    
    private function elastic_slider_cookie_check()
    {
        if(isset($_COOKIE['elastic_slider_cookie'])) { return true; }
        return false;
    }
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Elastic_Slide_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Elastic_Slide_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if ($this->Active_Marker) {
            wp_enqueue_style($this->Elastic_Slide, plugin_dir_url(__FILE__) . 'css/elastic-slide-public.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Elastic_Slide_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Elastic_Slide_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        if ($this->Active_Marker) {
            wp_enqueue_script($this->Elastic_Slide, plugin_dir_url(__FILE__) . 'js/elastic-slide-public.js', array('jquery'), $this->version, false);
            wp_localize_script($this->Elastic_Slide, 'php_vars', Elastic_Slide::get_settings());
        }
    }

    //add_filter( 'wp_footer' , 'your_other_function' );
    public function elastic_slider_html_insert() {
        if ($this->Active_Marker) {
            $content = stripslashes(get_option('elastic_slider_content'));
            echo do_shortcode(wpautop($this->elastic_slider_insert_parse_content(Elastic_Slide_Loader::elastic_slider_get_template('elastic-slide-public-display'), $content)));
        }
    }

    public function elastic_slider_insert_parse_content($template, $content) {
        return str_replace('{{content}}', $content, $template);
    }

}
