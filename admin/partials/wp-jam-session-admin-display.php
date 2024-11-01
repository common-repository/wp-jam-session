<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wp_Jam_Session
 * @subpackage Wp_Jam_Session/admin/partials
 */
?>

<!-- This file should primarily consist of PHP with a little bit of HTML. -->
<div id="settings-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-md-8">
       <div class="row">
       <div id="message"></div>
        <div class="col-xs-12 setting-area">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#settings-tab">Settings</a></li>
            <li><a data-toggle="tab" href="#faq-tab">FAQ</a></li>
          </ul> <!-- end nav-tabs -->
          <div class="tab-content">

          <?php
          /**
          *
          * This will load all of the settings
          *
          * This loads the settings form
          * 
          * 
          * @since 1.0.0
          */
          include plugin_dir_path( __FILE__ ) . 'wp-jam-session-settings-tab.php';

          /**
          *
          * This will load the FAQ tab
          *
          * 
          * 
          * 
          * @since 1.0.0
          */
          include plugin_dir_path( __FILE__ ) . 'wp-jam-session-faq-tab.php'; 
          ?>
      
          </div> <!-- end tab-content -->
        </div> <!-- end col setting-area -->
      </div> <!-- end row -->
    </div> <!-- end col -->
    <div class="col-xs-12 col-md-4 ads-area">
      <div class="row">
        <div class="col-xs-12 text-center">
          <h1>NEWS & UPDATES</h1>
        </div> <!-- end col -->
      </div> <!-- end row -->
      <div class="row">
        <div class="col-xs-12 text-center">
          <a href="https://wonkasoft.com/clixplit" id="first-ad" target="blank">
            <img class="img-responsive center-block" src="<?php echo plugins_url( '/wp-jam-session/admin/img/clixplit-ad.jpg' ); ?>" />
          </a>
        </div> <!-- end col -->
      </div> <!-- end row -->
      <div class="row">
        <div class="col-xs-12 text-center">
          <a href="https://wonkasoft.com" id="second-ad" target="blank">
            <img class="img-responsive center-block" src="<?php echo plugins_url( '/wp-jam-session/admin/img/wonkasoft-ad.jpg' ); ?>" />
          </a>
        </div> <!-- end col -->
      </div> <!-- end row -->
      <div class="row">
        <div class="col-xs-12  text-center">
          <p>What's not out there? <br />
            What business product/service/tool/app <br />
            would you like someone to create?</p>
            <button class="btn jam-btn" data-toggle="modal" data-target="#idea-form">FEED BACK</button>
          </div> <!-- end col -->
          <?php

          /**
          *
          * This will load the request modal dialog
          *
          * 
          * 
          * 
          * @since 1.0.0
          */
          include plugin_dir_path( __FILE__ ) . 'wp-jam-session-request.php'; 
          ?>

        </div> <!-- end row -->
        <div class="row">
          <div class="col-xs-12 text-center donate-btn">
            <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=Q7CMR62MS7KCJ" target="_blank"><button class="btn jam-btn">DONATE</button></a>
          </div> <!-- end col -->
        </div> <!-- end row -->
      </div> <!-- end col -->
    </div> <!-- end row -->
  </div> <!-- end container-fuild -->
</div> <!-- end settings-wrapper -->