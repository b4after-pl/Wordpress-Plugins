<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Elastic_Slide
 * @subpackage Elastic_Slide/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Elastic_Slide
 * @subpackage Elastic_Slide/admin
 * @author     Your Name <email@example.com>
 */
class Elastic_Slide_Admin {

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
     * @param      string    $Elastic_Slide       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($Elastic_Slide, $version) {

        $this->Elastic_Slide = $Elastic_Slide;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
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
        wp_enqueue_style($this->Elastic_Slide, plugin_dir_url(__FILE__) . 'css/elastic-slide-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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
        wp_enqueue_script($this->Elastic_Slide, plugin_dir_url(__FILE__) . 'js/elastic-slide-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Add Elastic Slide option page
     * 
     * @since 1.0.0
     */
    public function add_elastic_slide_options_page() {
        add_options_page(
            __('Elastic Slider'),
            __('Elastic Slider Settings'),
            'manage_options',
            'elastic-slider-plugin-page',
            array('Elastic_Slide_Admin', 'elastic_slider_options_page') // nazwa klasy oraz nazwa funkcji aby wp wykonywał funkcję wewnątrz klasy
        );
        
    }
    
    public function elastic_slider_settings_setup()
    {
        $settings_section = 'elastic-slider-options';
        $var_activate = 'elastic-slider-active';
        
        if(WP_DEBUG) echo 'Section name: '.$settings_section.PHP_EOL;
        if(WP_DEBUG) echo 'Active var: '.$var_activate.PHP_EOL;
        
        add_settings_section( 
                $settings_section, 
                __('Elastic Slider Settings'), 
                'elastic_slider_options_page_head', 
                'elastic-slider-plugin-page' );
        
        add_settings_field( $id, $title, $callback, $page, $section, $args );
        add_settings_field( 
                $var_activate,                 
                __('Slider active'), 
                array('Elastic_Slide_Admin', 'elastic_slider_active'),
                'elastic-slider-plugin-page', 
                $settings_section,
                array('label'=>__('Active?:'), 'label_for'=>'elastic_slider_active'));
        
        register_setting( $settings_section, $var_activate);
    }
    
    public static function elastic_slider_options_page_head()
    {
        echo 'Sekcja';
    }
    
    public static function  elastic_slider_active() {
        echo '<label for="'.$label_for.'">'.$label.'</label>'; exit();
    }
    
    public static function elastic_slider_options_page() { ?>
        <div class="wrap">
        <h2>My Plugin Options</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'elastic-slider-options' ); ?>
            <?php do_settings_sections( 'elastic-slider-options' ); ?>
            <?php do_settings_fields( 'elastic-slider-plugin-page', 'elastic-slider-options'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php }
    
    

}
