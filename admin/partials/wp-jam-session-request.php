<?php
/**
 * Provide a markup area for the request modal for the plugin
 *
 * This file is used to markup the request modal aspects of the plugin.
 *
 * @link       https://wonkasoft.com
 * @since      1.0.0
 *
 * @package    Wp_Jam_Session
 * @subpackage Wp_Jam_Session/admin/partials
 */
?>

<!-- Modal -->
<div class="modal fade" id="idea-form" role="dialog">
  <div class="modal-dialog">
    <?php $first_num = rand( 0,9 ); $second_num = rand( 0,9 ); $js_validation = $first_num + $second_num;
    $errName = "";
    $errEmail = "";
    $errHuman = "";
    $result = "";
    $js_validate = ( !isset( $_POST['js-validate'] ) ) ? "": intval( $_POST['js-validate'] );
    $name = ( !isset( $_POST['name'] ) ) ? "": sanitize_text_field( $_POST['name'] );
    $email = ( !isset( $_POST['email'] ) ) ? "": sanitize_email( $_POST['email'] );
    $news_letter = ( !isset( $_POST['newsletter'] ) ) ? "": sanitize_email( $_POST['newsletter'] );
    $message = ( !isset( $_POST['message'] ) ) ? "": sanitize_textarea_field( $_POST['message'] );
    $human = ( !isset( $_POST['human'] ) ) ? "": intval( $_POST['human'] );
    if ( isset( $_POST['submit'] ) ) {
      $from = 'WP JAM SESSION REQUEST FORM'; 
      $to = 'support@wonkasoft.com'; 
      $subject = 'Message from Jam Session request form';

      $body = "From: $name\n E-Mail: $email\n Newsletter: $news_letter\n Message:\n $message";
      if ( !$_POST['name'] ) {
        $errName = 'Please enter your name';
      }
      if ( !$_POST['email'] || !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ) {
        $errEmail = 'Please enter a valid email address';
      }
      if ( $human !== $js_validate ) {
        $errHuman = 'Your anti-spam is incorrect';
      }

      
                  // If there are no errors, send the email
      if ( !$errName && !$errEmail && !$errHuman ) {
        if ( mail ( $to, $subject, $body, $from ) ) {
          $result='<div class="alert alert-success">Thank You! I will be in touch</div>';
        } else {
          $result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later</div>';
        }
      }
    }
    ?>

    <!-- Modal content for request form-->
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Got an Idea? <span class="glyphicon glyphicon-send"></span></h4>
      </div>
      <div class="modal-body">
        <form id="modal-form" class="form-horizontal" role="form" method="post">
          <div class="form-group">
            <div class="col-xs-12">
              <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php $name = ( !isset( $_POST['name'] ) ) ? "": sanitize_text_field( $_POST['name'] ); echo $name; ?>">
              <?php echo "<p class='text-danger'>$errName</p>";?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php $email = ( !isset( $_POST['email'] ) ) ? "": sanitize_email( $_POST['email'] ); echo $email; ?>">
              <?php echo "<p class='text-danger'>$errEmail</p>";?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <textarea class="form-control" rows="4" name="message" placeholder="Your Message"><?php $message = ( !isset( $_POST['message'] ) ) ? "": sanitize_text_field( $_POST['message'] ); echo $message; ?></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input type="hidden" class="form-control" id="js-validate" name="js-validate" value="<?php echo $js_validation; ?>">
              <input type="text" class="form-control" id="human" name="human" placeholder="<?php echo $first_num . ' + ' . $second_num . ' = ? This a human check'; ?>" value="<?php $human = ( !isset( $_POST['human'] ) ) ? "": sanitize_text_field( $_POST['human'] ); echo $human; ?>">
              <?php echo "<p class='text-danger'>$errHuman</p>";?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label class="checkbox-inline"><input type="checkbox" name="newsletter" value="" checked="checked">Would you like to be added to our monthly newsletter?</label>
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <input id="submit" name="submit" type="submit" value="Send" class="btn jam-btn">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <?php echo $result; ?>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn jam-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>