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
        // Add the color picker css file       
        wp_enqueue_style( 'wp-color-picker' ); 
        
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
         
        // Include our custom jQuery file with WordPress Color Picker dependency
        wp_enqueue_script( 'elastic-slider-color-picker', plugins_url( 'js/elastic-slider-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
    
        
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
        
       // add_settings_field( $id, $title, $callback, $page, $section, $args );
        foreach(Elastic_Slide::elastic_slider_get_fields() as $field):
            add_settings_field( 
                    $field['name'],                 
                    __($field['label']), 
                    array('Elastic_Slide_Admin', $field['name']),
                    'elastic-slider-plugin-page', 
                    $settings_section);

            register_setting( $settings_section, $field['name']);
        endforeach;
    }
    
    public static function elastic_slider_options_page_head()
    {
        echo 'Sekcja';
    }
    
    private static function elastic_slider_get_field_template(Array $field)
    {
        if(!isset($field['type'])) $field['type'] = 'text';
        $tmp_field = false;
        $tmp_field  = '<div>';
        $tmp_field .= '<label for="'.$field['name'].'">'.$field['label'].'</label>'; 
        
        if($field['type'] == 'text') {
            $tmp_field .= '<input type="text" name="'.$field['name'].'" value="'.esc_attr( get_option($field['name']) ).'" />';
        } elseif($field['type'] == 'select') {
            
        } elseif($field['type'] == 'color') {
            $tmp_field .= '<input type="text" name="'.$field['name'].'" value="'.esc_attr( get_option($field['name']) ).'" class="color-field" />';
        } elseif($field['type'] == 'checkbox') {
            $tmp_field .= '<input type="checkbox" name="'.$field['name'].'" value="true" '.checked( esc_attr( get_option($field['name']) ), 'true', false ).' />';
        }
        
        $tmp_field .= '</div>';
        
        return $tmp_field;
    }
    
    private static function elastic_slider_display_fields() {
        
        foreach(Elastic_Slide::elastic_slider_get_fields() as $field):
            echo Elastic_Slide_Admin::elastic_slider_get_field_template($field);
        endforeach;
    }
    
    public static function elastic_slider_options_page() { ?>
        <div class="wrap">
        <h2>My Plugin Options</h2>
        <form method="post" action="options.php">
            <?php settings_fields( 'elastic-slider-options' ); ?>
            <?php Elastic_Slide_Admin::elastic_slider_display_fields(); ?>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php }
    
    

}
