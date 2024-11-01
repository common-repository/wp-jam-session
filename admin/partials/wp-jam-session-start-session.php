<?php
/**
* The admin-specific functionality of the plugin.
*
* @link       https://wonkasoft.com
* @since      1.0.0
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
if ( !defined( 'ABSPATH' ) ) {
  echo 'This session is exiting';
  exit;
} 

// Load all settings into globals for checks
// $GLOBALS['set_parmeter'] = ( !empty( get_option( 'wp-jam-session-url-para' ) ) ) ? get_option( 'wp-jam-session-url-para' ): '' ;
  $GLOBALS['set_parmeter'] = ( !empty( get_option( 'wp-jam-session-url-para' ) ) ) ? get_option( 'wp-jam-session-url-para' ): '' ;
  $GLOBALS['allowed_value'] = ( !empty( get_option( 'wp-jam-session-input-para' ) ) ) ? get_option( 'wp-jam-session-input-para' ): '' ;
  $GLOBALS['form_type'] = ( !empty( get_option( 'wp-jam-session-type-form' ) ) ) ? get_option( 'wp-jam-session-type-form' ): '' ;
  $GLOBALS['field_id'] = ( !empty( get_option( 'wp-jam-session-field-id' ) ) ) ? get_option( 'wp-jam-session-field-id' ): '' ;
  $GLOBALS['session_term_time'] = ( !empty( get_option( 'wp-jam-session-term-time' ) ) ) ? get_option( 'wp-jam-session-term-time' ): 1;

// Check for a started session if not start the session
if ( !session_id() ) {
  session_start();
  if ( $_SESSION['expiration'] == '' ) {
    $add = new DateInterval( "PT".$GLOBALS['session_term_time']."H" ); // Interval of term in hours
    $date = new DateTime(); // Current time
    $date->add($add); // adds term time from settings page
    $expiration = $date->format( 'mdH' ); // loads the expiration time
    $_SESSION['expiration'] = $expiration;
  }
}

add_action( 'wp_logout', 'wp_jam_session_end_session' );

// End session on logout
function wp_jam_session_end_session() {
  session_destroy ();
}

add_action( 'wp_head', 'wp_jam_session_header_config' );

function wp_jam_session_header_config() {
  // load current time for expiration check
  $current_time = date( 'mdH' );

  // Checking expiration time of a session and destroying that which is expired
  if ( $current_time > $_SESSION['expiration'] ) {
    session_destroy();
  }
  
  // Checking the parmeter variable for a set value
  if ( !empty( $_GET[$GLOBALS['set_parmeter']] ) ) {
    
    // Check for parameter match and value match, then set session variable.
    if ( $_GET[$GLOBALS['set_parmeter']] !== null &&  in_array( $_GET[$GLOBALS['set_parmeter']], $GLOBALS['allowed_value'] ) ) {  
      
      // Set the session variable
      $_SESSION['value'] = ( !empty( $_GET[$GLOBALS['set_parmeter']] ) ) ? sanitize_text_field($_GET[$GLOBALS['set_parmeter']] ): '';
    } 
  }
}

// Check for form type and if it is WooCommerce run form filter
if ( $GLOBALS['form_type'] == 'WooCommerce' ) {
  add_filter( 'woocommerce_checkout_fields', 'wp_jam_session_load_wc_form', 10, 1 );
}

// Add value to the selected woocommerce form, from the session variable
function wp_jam_session_load_wc_form( $fields ) {
  if ( !empty( $_SESSION['value'] ) ) {
    $fields['billing'][$GLOBALS['field_id']]['default'] = $_SESSION['value'];
    $fields['billing'][$GLOBALS['field_id']]['custom_attributes'] = array( 'readonly' => 'readonly' );
  }
  return $fields;
}

// Check for form type and if it is Contact Form 7 run form filter
if ( $GLOBALS['form_type'] == 'Contact Form 7' ) {
  add_filter( 'wpcf7_contact_form_properties', 'wp_jam_session_load_cf7_form', 10, 1 );
}

// Add value to the selected Contact Form 7 form, from the session variable
function wp_jam_session_load_cf7_form( $properties ) { 
  if ( !empty( $_SESSION['value'] ) && !is_admin() ) {
    $form_id = 'id:'.$GLOBALS['field_id'];
    $parameter_value = '"'.$_SESSION['value'].'"';
    $properties['form'] = strtolower( $properties['form'] );
    $load_value = str_replace( $form_id, $form_id . ' readonly ' .$parameter_value, $properties['form'] );
    $properties['form'] = $load_value; 
  }
  return $properties; 
}

// Check for form type and if it is Ninja Forms run form filter
if ( $GLOBALS['form_type'] == 'Ninja Forms' ) {
  add_filter( 'ninja_forms_render_default_value', 'wp_jam_session_load_ninja_form', 10, 3 );
}

// Add value to the selected Ninja form, from the session variable
function wp_jam_session_load_ninja_form( $default_value, $field_class, $field_settings ) { 
    if ( !empty( $_SESSION['value'] ) ) {
      if ( strtolower( $field_settings['label'] ) == $GLOBALS['field_id'] ) {
        $default_value = $_SESSION['value'];
      }
    }
  return $default_value;
}