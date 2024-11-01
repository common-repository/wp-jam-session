 <?php
/**
 * Provide a markup area for the settings form for the plugin
 * This file is used to markup the settings form aspects of the plugin.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 * @package    Wp_Jam_Session
 * @subpackage Wp_Jam_Session/admin/partials
 */
?>

<div id="settings-tab" class="tab-pane fade in active">
  <div class="row title-row">
    <div class="col-xs-12 col-md-3">
      <img class="img-responsive block-center jam-logo" src="<?php echo plugins_url( '/wp-jam-session/admin/img/jam-session-logo.png' ); ?>" />
    </div>
    <div class="col-xs-12 col-md-8">
      <h1>WP JAM SESSION</h1>
      <h4>Welcome to  WP Jam Session!<br />
        With WP Jam Session you can setup links with customized parameters that will automatically place the customized parameters into a form for the user.</h4>
      </div>
    </div> <!-- end row -->
    <div class="row">
      <div class="col-xs-12 form-area">
        <form id="settings-form" action="<?php echo plugin_dir_url( __FILE__ ) . 'wp-jam-session-settings-ajax.php'; ?>">
          <div class="col-xs-12 col-sm-6 col-md-9">
          <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="url-para">Add URL Parameter: </label>
              <p>example: ?yourParameterHere= <span data-toggle="tooltip" data-placement="top" title="This would be where you would put your custom parameter." class="help-badge"><strong>?</strong></span></p>
              <input type="text" name="url-para" class="form-control" id="url-para" value="<?php echo get_option( 'wp-jam-session-url-para' ) ?>" maxlength="15">
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
            <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="input-para">Inputs for validation: </label>
              <p>example: ?yourParameterHere= thisInputHere <span data-toggle="tooltip" data-placement="top" title="This would be where you would put the input for your parameter." class="help-badge"><strong>?</strong></span></p>
              <input type="text" name="input-para" class="form-control" id="input-para" value="" maxlength="80">
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
            <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="type-form">Type of Form: </label>
              <p>example: Select form plugin <span data-toggle="tooltip" data-placement="top" title="Please select the type of form that you are using." class="help-badge"><strong>?</strong></span></p>
              <select type="select" name="type-form" class="form-control" id="type-form">
              <?php  
                $selected_option = get_option( 'wp-jam-session-type-form' );
                switch ( $selected_option ) {
                  
                  case 'WooCommerce': ?>
                    <option value="" disabled>Select your option</option>
                    <option value="WooCommerce" selected>WooCommerce</option>
                    <option value="Contact Form 7">Contact Form 7</option>
                    <option value="Ninja Forms">Ninja Forms</option>
                    <option value="Gravity Forms">Gravity Forms - pro version only</option>

                    <?php
                    break;

                    case 'Contact Form 7': 
                    ?>
                    <option value="" disabled>Select your option</option>
                    <option value="WooCommerce">WooCommerce</option>
                    <option value="Contact Form 7" selected>Contact Form 7</option>
                    <option value="Ninja Forms">Ninja Forms</option>
                    <option value="Gravity Forms">Gravity Forms - pro version only</option>
                    
                    <?php
                    break;

                    case 'Ninja Forms': 
                    ?>
                    <option value="" disabled>Select your option</option>
                    <option value="WooCommerce">WooCommerce</option>
                    <option value="Contact Form 7">Contact Form 7</option>
                    <option value="Ninja Forms" selected>Ninja Forms</option>
                    <option value="Gravity Forms">Gravity Forms - pro version only</option>

                    <?php
                    break;

                    case 'Gravity Forms': 
                    ?>
                    <option value="" disabled>Select your option</option>
                    <option value="WooCommerce">WooCommerce</option>
                    <option value="Contact Form 7">Contact Form 7</option>
                    <option value="Ninja Forms">Ninja Forms</option>
                    <option value="Gravity Forms" selected>Gravity Forms - pro version only</option>

                    <?php
                    break;
                  
                  default: 
                  ?>
                  <option value="" disabled selected>Select your option</option>
                  <option value="WooCommerce">WooCommerce</option>
                  <option value="Contact Form 7">Contact Form 7</option>
                  <option value="Ninja Forms">Ninja Forms</option>
                  <option value="Gravity Forms">Gravity Forms - pro version only</option>

                  <?php
                    break;
                }
              ?>
              </select>
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
            <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="field-id">Input Field ID: </label>
              <p>example: Input ID to receive parameter input <span data-toggle="tooltip" data-placement="top" title="Place field ID that you want to place the parameters input into." class="help-badge"><strong>?</strong></span></p>
              <input type="text" name="field-id" class="form-control" id="field-id" value="<?php echo get_option( 'wp-jam-session-field-id' ) ?>" maxlength="25">
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
            <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="term-time">Set the page URL for parameter link: </label>
              <p>example: Set a specific page for link creation <span data-toggle="tooltip" data-placement="top" title="Default will be your home page or you can set a page of your choice." class="help-badge"><strong>?</strong></span></p>
              <?php 
              $pages_dropdown = array(
                'selected' => get_site_url(),
                'name' => 'page-id',
                'id' => 'page-id',
                'class' => 'form-control',
                'show_option_none' => 'Home by Default',
                'option_none_value' => get_site_url(),
                'value_field' => 'guid',
                );
              wp_dropdown_pages( $pages_dropdown ); 
              ?>
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
            <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="term-time">Session Termination Time: </label>
              <p>example: Time in hours to terminate session <span data-toggle="tooltip" data-placement="top" title="Here you can set the time you allow for the users session." class="help-badge"><strong>?</strong></span></p>
              <input type="text" name="term-time" class="form-control" id="term-time" value="<?php $term_time_check = ( !empty( get_option( 'wp-jam-session-term-time' ) ) ) ? get_option( 'wp-jam-session-term-time' ) : 1; echo $term_time_check; ?>" maxlength="2">
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
            <div class="col-xs-12 col-md-6">
            <div class="form-group">
              <label for="created-url">Here is your new URL with parameters: </label>
              <p>You can quickly copy this by clicking the clipboard button. <span data-toggle="tooltip" data-placement="top" title="You can quickly copy this link by clicking the button to the right of the url." class="help-badge"><strong>?</strong></span></p>
              <div class="input-group">
              <div class="input-group-btn copy-btn-div">
              <input name="created-url" id="created-url" class="form-control" value="" readonly="true" =""><button id="copy-btn-id" class="btn btn-info" type="button"><i class="glyphicon glyphicon-copy copy-btn pull-right"></i></button>
              </div> <!-- end button wrap -->
              </div> <!-- end input-group -->
            </div> <!-- end form-group -->
            </div> <!-- end of this items col -->
          </div> <!-- end first col -->
          <div class="col-xs-12 col-sm-6 col-md-3">
          <?php 
          /**
          *
          * This is for displaying the accepted values list on the settings tab.
          *
          *
          * @since    1.0.0
          */
          include plugin_dir_path( __FILE__ ) . 'wp-jam-session-accepted-values.php'; 
          ?>

          </div>
          <div class="col-xs-12">
            <button type="submit" id="save-settings" class="btn jam-btn pull-right">SAVE <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></button>
          </div>
        </form>
        </div>
      </div>
    </div> <!-- end settings-tab -->