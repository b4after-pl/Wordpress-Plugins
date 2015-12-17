<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Elastic_Slide
 * @subpackage Elastic_Slide/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Elastic_Slide
 * @subpackage Elastic_Slide/includes
 * @author     Your Name <email@example.com>
 */
class Elastic_Slide {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Elastic_Slide_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $Elastic_Slide    The string used to uniquely identify this plugin.
	 */
	protected $Elastic_Slide;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
        
        protected $fields;
        

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

                
               
		$this->Elastic_Slide = 'elastic-slide';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}
        
        public static function elastic_slider_get_fields()
        {
             $fields = array(
                    array('name'=>'elastic_slider_active', 'label'=>'Is active?', 'type'=>'checkbox'),
                    array('name'=>'elastic_slider_start_delay', 'label'=>'Show popup after X seconds'),
                    array('name'=>'elastic_slider_animation_duration', 'label'=>'Animation duration'),
                    array('name'=>'elastic_slider_background_color', 'label'=>'Background color', 'type'=>'color'),
                    array('name'=>'elastic_slider_font_color', 'label'=>'Text color', 'type'=>'color'),
                    array('name'=>'elastic_slider_content', 'label'=>'Popup content', 'type'=>'editor')
                );
            return $fields;
        }
        
        public static function get_settings()
        {
           $settings = array();
           foreach(Elastic_Slide::elastic_slider_get_fields() as $field):
            $settings[$field['name']] = esc_attr( get_option($field['name']) );
           endforeach;
           return $settings;
            
        }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Elastic_Slide_Loader. Orchestrates the hooks of the plugin.
	 * - Elastic_Slide_i18n. Defines internationalization functionality.
	 * - Elastic_Slide_Admin. Defines all hooks for the admin area.
	 * - Elastic_Slide_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-elastic-slide-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-elastic-slide-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-elastic-slide-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-elastic-slide-public.php';

		$this->loader = new Elastic_Slide_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Elastic_Slide_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Elastic_Slide_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Elastic_Slide_Admin( $this->get_Elastic_Slide(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_elastic_slide_options_page'); 
                $this->loader->add_action( 'admin_init', $plugin_admin, 'elastic_slider_settings_setup');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Elastic_Slide_Public( $this->get_Elastic_Slide(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
                $this->loader->add_action( 'wp_footer', $plugin_public, 'elastic_slider_html_insert');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_Elastic_Slide() {
		return $this->Elastic_Slide;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Elastic_Slide_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
