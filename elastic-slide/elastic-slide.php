<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.b4after.pl/wordpress/elastic-slide-plugin
 * @since             1.0.0
 * @package           Elastic Slide
 *
 * @wordpress-plugin
 * Plugin Name: Elastic Slide
 * Plugin URI: http://www.b4after.pl/wordpress/elastic-slide
 * Description: Elegant and light popup slider build with HTML5 and CSS3
 * Version: 1.0.0
 * Author: BEFORE AFTER
 * Author URI: http://www.b4after.pl
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: elastic-slide
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-elastic-slide-activator.php
 */
function activate_Elastic_Slide() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elastic-slide-activator.php';
	Elastic_Slide_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-elastic-slide-deactivator.php
 */
function deactivate_Elastic_Slide() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-elastic-slide-deactivator.php';
	Elastic_Slide_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Elastic_Slide' );
register_deactivation_hook( __FILE__, 'deactivate_Elastic_Slide' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-elastic-slide.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Elastic_Slide() {

	$plugin = new Elastic_Slide();
	$plugin->run();

}
add_action('plugins_loaded', 'run_Elastic_Slide');
