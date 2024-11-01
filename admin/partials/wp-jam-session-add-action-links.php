<?php
/**
* The admin-specific functionality of the plugin.
*
* @link       https://wonkasoft.com
* @since      1.1.0
*
* @package    Wp_Jam_Session
* @subpackage Wp_Jam_Session/admin
*/

/**
* The admin-specific functionality of the plugin.
*
* Defines the plugin name, version, and two examples hooks for how to
* enqueue the admin-specific stylesheet and JavaScript.
*
* @package    Wp_Jam_Session
* @subpackage Wp_Jam_Session/admin
* @author     Wonkasoft <info@wonkasoft.com>
*/

add_filter( 'plugin_action_links_'. JAM_SESSION_BASENAME, 'wp_jam_session_add_settings_link_filter' , 10, 1);

function wp_jam_session_add_settings_link_filter( $links ) { 
	global $wp_jam_session_page;
	$settings_link = '<a href="' . menu_page_url( $wp_jam_session_page, 0 ) . '">Settings</a>';
	array_unshift( $links, $settings_link); 
	$links[] = '<a href="https://paypal.me/Wonkasoft" target="blank"><img src="' . plugins_url( '../img/wonka-logo.svg', __FILE__ ) . '" style="width: 20px; height: 20px; display: inline-block;
	vertical-align: text-top; float: none;" /></a>';
	return $links; 
}

add_filter( 'plugin_row_meta', 'jam_session_add_description_link_filter', 10, 2);

function jam_session_add_description_link_filter( $links, $file ) {
	global $wp_jam_session_page;
	if ( strpos($file, 'wp-jam-session.php') !== false ) {
		$links[] = '<a href="' . menu_page_url( $wp_jam_session_page, 0 ) . '" target="_self">Settings</a>';
		$links[] = '<a href="https://wonkasoft.com/wp-jam-session" target="blank">Support</a>';
		$links[] = '<a href="https://paypal.me/Wonkasoft" target="blank">Donate <img src="' . plugins_url( '../img/wonka-logo.svg', __FILE__ ) . '" style="width: 20px; height: 20px; display: inline-block; vertical-align: text-top;" /></a>';
	}
	return $links; 
}