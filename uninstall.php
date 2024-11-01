<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wp_Jam_Session
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Checking for user permissions before deleting the database 
if ( current_user_can('manage_options') ) {
	
	if ( get_option( 'wp-jam-session-url-para' ) ) {
  		delete_option( 'wp-jam-session-url-para' );
	}
	if ( get_option( 'wp-jam-session-input-para' ) ) {
  		delete_option( 'wp-jam-session-input-para' );
	}

	if ( get_option( 'wp-jam-session-type-form' ) ) {
  		delete_option( 'wp-jam-session-type-form' );
	}

	if ( get_option( 'wp-jam-session-field-id' ) ) {
  		delete_option( 'wp-jam-session-field-id' );
	}

	if ( get_option( 'wp-jam-session-term-time' ) ) {
  		delete_option( 'wp-jam-session-term-time' );
	}
}
