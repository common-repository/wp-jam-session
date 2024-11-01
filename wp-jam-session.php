<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wonkasoft.com
 * @since             1.1.0
 * @package           Wp_Jam_Session
 *
 * @wordpress-plugin
 * Plugin Name:       WP Jam Session
 * Plugin URI:        https://wonkasoft.com/wp-jam-session
 * Description:       Wonkasoft's WP Jam Session is a plugin that will increase your analytical leverage. Use WP Jam Session to automatically fill in referrals, sales representative IDs, or any additional personalized tags. You can track what you want, how you want it.
 * Version:           1.1.1
 * Author:            Wonkasoft
 * Author URI:        https://wonkasoft.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-jam-session
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define contants
 */
define( 'JAM_SESSION_PATH', plugin_dir_path( __FILE__ ) );
define( 'JAM_SESSION_NAME', plugin_basename(dirname( __FILE__ ) ) );
define( 'JAM_SESSION_BASENAME', plugin_basename( __FILE__ ) );
define( 'JAM_SESSION_VERSION', '1.1.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-jam-session-activator.php
 */
function activate_wp_jam_session() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-jam-session-activator.php';
  Wp_Jam_Session_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-jam-session-deactivator.php
 */
function deactivate_wp_jam_session() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-jam-session-deactivator.php';
  Wp_Jam_Session_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_jam_session' );
register_deactivation_hook( __FILE__, 'deactivate_wp_jam_session' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-jam-session.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_jam_session() {

	$plugin = new Wp_Jam_Session();
	$plugin->run();

}

run_wp_jam_session();