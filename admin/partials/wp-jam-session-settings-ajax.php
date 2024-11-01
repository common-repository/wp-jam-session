<?php
/**
* Run ajax for settings form
*
* This file is used to process all of the settings form data for the plugin.
*
* @link       https://wonkasoft.com
* @since      1.0.0
* @access   private
*
* @package    Wp_Jam_Session
* @subpackage Wp_Jam_Session/admin/partials
*/
if ( !defined( 'ABSPATH' ) ) {
  echo 'I am exiting';
  exit;
}
global $wpdb;

// This is for building the accepted values list on the settings page of WP-Jam-Session.
add_action( 'wp_ajax_build_values_list', 'wp_jam_values_list_build' );
function wp_jam_values_list_build() {

// This is a security check, it validates a random number that is generated on the request.
if ( !check_ajax_referer( 'wp-jam-number', 'security' ) ) {
  return wp_send_json_error( 'Invalid Nonce' );
}

// This is for grabbing and filtering the accepted values array before sending it back to the list build.
$input_array_onload = ( !empty( get_option( 'wp-jam-session-input-para' ) ) ) ? get_option( 'wp-jam-session-input-para' ): array();
$input_array_onload = array_filter( $input_array_onload );
 return wp_send_json_success( $input_array_onload );
 wp_die();
}

// This is for removing a value from the accepted value list on the WP-Jam-Session settings page.
add_action( 'wp_ajax_remove_value_item', 'wp_jam_value_item_remove' );
function wp_jam_value_item_remove() {

// Nonce checking
if ( !check_ajax_referer( 'wp-jam-number', 'security' ) ) {
return wp_send_json_error( 'Invalid Nonce' );
}

// This is for cleaning and fixing the array of accepted values before sending the list back.
  $input_array_remove = ( !empty( get_option( 'wp-jam-session-input-para' ) ) ) ? get_option( 'wp-jam-session-input-para' ): array();
  if( ( $key = array_search( $_POST['data'], $input_array_remove ) ) !== false ) {
    unset( $input_array_remove[$key] );
    $input_array_remove = array_values( $input_array_remove );
  }
  if( ( $key = array_search( '', $input_array_remove ) ) !== false ) {
    unset( $input_array_remove[$key] );
    $input_array_remove = array_values( $input_array_remove );
  }
  update_option( 'wp-jam-session-input-para', $input_array_remove, 'yes' );
  return wp_send_json_success( $input_array_remove );
  wp_die();
}

// This is run when the save button is hit on the settings page.
add_action( 'wp_ajax_save_settings', 'wp_jam_settings_save' );
function wp_jam_settings_save() {

// Nonce checking
  if ( !check_ajax_referer( 'wp-jam-number', 'security' ) ) {
return wp_send_json_error( 'Invalid Nonce' );
}

// This is for loading the data into the appropriate $_POST[] varibles.
foreach ( $_POST['data'] as $key => $value ) {
  $name = $value['name'];
  $value = $value['value'];
  $_POST[$name] = $value;
}

// This is just for sanitizing all the data that was sent.
$url_para = ( !isset( $_POST['url-para'] ) ) ? '': sanitize_text_field( $_POST['url-para'] );
$url_para =  str_replace( ' ', '', strtolower( $url_para ) );
$input_para = ( !isset( $_POST['input-para'] ) ) ? '': sanitize_text_field( $_POST['input-para'] );
$input_para =  strtolower( $input_para );
$type_form = ( !isset( $_POST['type-form'] ) ) ? '': sanitize_text_field( $_POST['type-form'] );
$field_id = ( !isset( $_POST['field-id'] ) ) ? '': sanitize_text_field( $_POST['field-id'] );
$field_id = str_replace( " ","",strtolower( $field_id ) );
$term_time = ( !isset( $_POST['term-time'] ) ) ? '': sanitize_text_field( $_POST['term-time'] );
$term_time = str_replace( " ","",$term_time );
$values_array = ( !empty( get_option( 'wp-jam-session-input-para' ) ) ) ? get_option( 'wp-jam-session-input-para' ): array();

  if ( !empty( $_POST['url-para'] ) ) {
    update_option( 'wp-jam-session-url-para', $url_para, 'yes' );
  }

  if ( !empty( $_POST['type-form'] ) ) {
    update_option( 'wp-jam-session-type-form', $type_form, 'yes' );
  }

  if ( !empty( $_POST['field-id'] ) ) {
    update_option( 'wp-jam-session-field-id', $field_id, 'yes' );
  }

  if ( !empty( $_POST['term-time'] ) ) {
    update_option( 'wp-jam-session-term-time', $term_time, 'yes' );
  }
  
  if ( !empty( $_POST['input-para'] ) ) {
    $input_array = ( !empty( get_option( 'wp-jam-session-input-para' ) ) ) ? get_option( 'wp-jam-session-input-para' ): array();
    $input_para = str_replace( ",", " ", $input_para );
    $cleaning_array = explode( " ", $input_para );
    foreach ( $cleaning_array as $value ) {
      array_push( $input_array, $value );
    }
    $input_array = array_unique( $input_array );
    $input_array = array_filter( $input_array );
    $input_array = array_slice( $input_array, 0, 5 );

    update_option( 'wp-jam-session-input-para', $input_array, 'yes' );
    return wp_send_json_success( $input_array );
  } else {

    wp_send_json_success( $values_array );
  }

  wp_die();
}