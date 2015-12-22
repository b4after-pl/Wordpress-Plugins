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
        wp_enqueue_media();
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
        if(!isset($field['html_type'])) $field['html_type'] = 'text';
        if(!isset($field['multiple'])) $field['multiple'] = false;
        $tmp_field = false;
        
        
        if($field['type'] == 'text') {
            $tmp_field  = '<tr>'.PHP_EOL;
            $tmp_field .= '<th><label for="'.$field['name'].'">'.$field['label'].'</label></th>'.PHP_EOL; 
            $tmp_field .= '<td><input type="'.$field['html_type'].'" id="'.$field['name'].'" name="'.$field['name'].'" value="'.esc_attr( get_option($field['name']) ).'" />'.PHP_EOL;
            $tmp_field .=  '<br />'.__($field['help']).PHP_EOL;
            $tmp_field .= '<td></tr>'.PHP_EOL;
        } elseif($field['type'] === 'select') {
            $multiple = ($field['multiple'])?'multiple':'';
            echo get_option($field['name']);
            $tmp_field  = '<tr>'.PHP_EOL;
            $tmp_field .= '<th><label for="'.$field['name'].'">'.$field['label'].'</label></th>'.PHP_EOL; 
            $tmp_field .= '<td><select name="'.$field['name'].'" id="'.$field['name'].'" '.$multiple.'>'.PHP_EOL;
                foreach($field['options'] as $option){
                    $selected = (get_option($field['name'])===$option['name'])?'selected':'';
                    $tmp_field .= '<option value="'.$option['name'].'" '.$selected.'> '.$option['title'].' </option>'.PHP_EOL;
                }
            $tmp_field .= '</select>'.PHP_EOL;
            $tmp_field .=  '<br />'.__($field['help']).PHP_EOL;
            $tmp_field .= '<td></tr>'.PHP_EOL;
        } elseif($field['type'] === 'color') {
            $tmp_field  = '<tr>'.PHP_EOL;
            $tmp_field .= '<th><label for="'.$field['name'].'">'.$field['label'].'</label></th>'.PHP_EOL; 
            $tmp_field .= '<td><input type="text" id="'.$field['name'].'" name="'.$field['name'].'" value="'.esc_attr( get_option($field['name']) ).'" class="color-field" />'.PHP_EOL;
            $tmp_field .=  '<br />'.__($field['help']).PHP_EOL;
            $tmp_field .= '<td></tr>'.PHP_EOL;
        } elseif($field['type'] === 'checkbox') {
            $tmp_field  = '<tr>'.PHP_EOL;
            if(!$field['multiple']) {
                $tmp_field .= '<th><label for="'.$field['name'].'">'.$field['label'].'</label></th>'.PHP_EOL; 
                $tmp_field .= '<td><input type="checkbox" id="'.$field['name'].'" name="'.$field['name'].'" value="true" '.checked( esc_attr( get_option($field['name']) ), 'true', false ).' />';
                $tmp_field .=  '<br />'.__($field['help']).PHP_EOL;
                $tmp_field .= '<td></tr>'.PHP_EOL;
            } else {
                $tmp_field .= '<th>'.$field['label'].'</th>'.PHP_EOL; 
                $tmp_field .= '<td>'.PHP_EOL; 
                $opt_values = get_option($field['name']);
                foreach($field['options'] as $option) {
                     $tmp_field .= '<input type="checkbox" id="'.$field['name'].'_'.$option['name'].'" name="'.$field['name'].'['.$option['name'].']" value="true" '.checked( isset($opt_values[$option['name']]), true, false ).' /><label for="'.$field['name'].'_'.$option['name'].'">'.$option['title'].'</label><br />';
                }
                $tmp_field .=  '<br />'.__($field['help']).PHP_EOL;
                $tmp_field .= '<td></tr>'.PHP_EOL;
            }
                
        } elseif($field['type'] === 'editor') {
            echo '<tr>'.PHP_EOL;
            echo '<th><label for="'.$field['name'].'">'.$field['label'].'</label><br />'.__($field['help']).'</th>'.PHP_EOL; 
            echo '<td>'.PHP_EOL;
            wp_editor(stripslashes(esc_attr( get_option($field['name']) )), $field['name'], array('textarea_name' => $field['name']));
            echo '</td>'.PHP_EOL;
            echo '</tr>'.PHP_EOL;
        } elseif($field['type'] === 'upload') {
            $tmp_field .=  '<tr>'.PHP_EOL;
            $tmp_field .=  '<th><label for="upload_image">'.$field['label'].'</label></th>'.PHP_EOL;
            $tmp_field .=  '<td><input id="'.$field['name'].'" type="text" size="36" name="'.$field['name'].'" value="'.get_option($field['name']).'" />'.PHP_EOL; 
            $tmp_field .=  '<input data-inputid="'.$field['name'].'" class="upload_button button" type="button" value="'.__('Upload file').'" />'.PHP_EOL;
            $tmp_field .=  '<br />'.__($field['help']).PHP_EOL;
            $tmp_field .=  '</td>'.PHP_EOL;
            $tmp_field .=  '</tr>'.PHP_EOL;
        }
        
        return $tmp_field;
    }
    
    private static function elastic_slider_display_fields($group) {
        echo '<table class="form-table">'.PHP_EOL;
        foreach(Elastic_Slide::elastic_slider_get_fields() as $field):
            if($field['group']===$group){
                echo Elastic_Slide_Admin::elastic_slider_get_field_template($field);
            }
        endforeach;
        echo '</table>'.PHP_EOL;
    }
    
    public static function elastic_slider_options_page() { ?>
        <div class="wrap">
        <?php $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'settings';  ?> 
            <h2 class="nav-tab-wrapper">
	                <span class="nav-header">
		                <?php echo __('Elastic Slide Settings');?>
	                </span>
	                &nbsp;
	                <a href="#settings" data-tab="elastic_settings" class="nav-tab<?php echo ($active_tab==='settings')?' nav-tab-active':''?>"><?php echo __('Settings', 'elastic-slide'); ?></a>
	                <a href="#content" data-tab="elastic_content" class="nav-tab<?php echo ($active_tab==='content')?' nav-tab-active':''?>"><?php echo __('Content', 'elastic-slide'); ?></a>
	                <a href="#display" data-tab="elastic_display" class="nav-tab<?php echo ($active_tab==='display')?' nav-tab-active':''?>"><?php echo __('Display options', 'elastic-slide'); ?></a>
	                
	            </h2>
        
        <form method="post" action="options.php" id="elastic_slide_form">
        <?php settings_fields( 'elastic-slider-options' );
            ?><div id="elastic_settings" class="tab_box tab_show"><?php
            Elastic_Slide_Admin::elastic_slider_display_fields('settings');
            ?></div><?php
            ?><div id="elastic_content" class="tab_box"><?php
                Elastic_Slide_Admin::elastic_slider_display_fields('content');
            ?></div><?php
            ?><div id="elastic_display" class="tab_box"><?php
                Elastic_Slide_Admin::elastic_slider_display_fields('display');
            ?></div><?php
         submit_button(); 
         ?>
        </form>
    </div>
    <?php }
    
    

}
