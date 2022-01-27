<?php

  //response generation function

  $response = "";

  //function to generate response
  function my_contact_form_generate_response($type, $message){

    global $response;

    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";

  }

  //response messages
  $not_human       = "Human verification incorrect.";
  $missing_content = "Please supply all information.";
  $email_invalid   = "Email Address Invalid.";
  $message_unsent  = "Message was not sent. Try Again.";
  $message_sent    = "Thanks! Your message has been sent.";

  //user posted variables
  $name = $_POST['message_name'];
  $email = $_POST['message_email'];
  $message = $_POST['message_text'];
  $human = $_POST['message_human'];

  //php mailer variables
  $to = get_option('admin_email');
  $subject = "Someone sent a message from ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 2) my_contact_form_generate_response("error", $not_human); //not human!
    else {

      //validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else //email is valid
      {
        //validate presence of name and message
        if(empty($name) || empty($message)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
          $sent = wp_mail($to, $subject, strip_tags($message), $headers);
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
    }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);

?>

<?php get_header(); ?>

<section class="page-wrapper">
  <div class="pageWrapper">
    <div class="pagePost">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#contactUs">
      Contact us
      </button>
      <!-- Modal -->
      <form action="<?php the_permalink(); ?>" method="post" autocomplete="off">
        <div class="modal fade" id="contactUs" tabindex="-1" role="dialog" aria-labelledby="contactUsTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div id="modal-background" class="modal-content contact-modal-1">
              <div class="col-md-12 modal-header">
                <h1 class="modal-title">Contact Us</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: white; font-size: 50px;">&times;</span>
                </button>
              </div>
              <div class="col-md-12 modal-body">
                <div class="col-md-2 contact-modal-number">01</div>
                <div class="col-md-10">
                  <h2>Hello, what's your name?</h2>
                  <input class="form-control transparent-input" type="text" placeholder="First name, last name" required="" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>"></input>
                </div>
              </div>
              <div class="col-md-12 modal-footer">
                <button type="button" class="btn btn-primary" id="next1">Next →</button>
              </div>
              <div class="col-md-12 dotstyle dotstyle-fillup">
                <ul>
                  <li class="current"><a href="#"></a></li>
                  <li><a href="#"></a></li>
                  <li><a href="#"></a></li>
                  <li><a href="#"></a></li>
                </ul>
              </div>
            </div>
            <div class="modal-content contact-modal-2" style="display: none">
              <div class="col-md-12 modal-header">
                <h1 class="modal-title">Contact Us</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: white; font-size: 50px;">&times;</span>
                </button>
              </div>
              <div class="col-md-12 modal-body">
                <div class="col-md-2 contact-modal-number">02</div>
                <div class="col-md-10">
                  <h2>What's your email</h2>
                  <input class="form-control transparent-input" type="text" placeholder="email@example.com" required="" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></input>
                </div>
              </div>
              <div class="col-md-12 modal-footer">
                <button type="button" class="btn btn-secondary" id="previous2">← Previous</button>
                <button type="button" class="btn btn-primary" id="next2">Next →</button>
              </div>
              <div class="col-md-12 dotstyle dotstyle-fillup">
                <ul>
                  <li class="current"><a href="#"></a></li>
                  <li class="current"><a href="#"></a></li>
                  <li><a href="#"></a></li>
                  <li><a href="#"></a></li>
                </ul>
              </div>
            </div>
            <div class="modal-content contact-modal-3" style="display: none">
              <div class="col-md-12 modal-header">
                <h1 class="modal-title">Contact Us</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: white; font-size: 50px;">&times;</span>
                </button>
              </div>
              <div class="col-md-12 modal-body">
                <div class="col-md-2 contact-modal-number">03</div>
                <div class="col-md-10">
                  <h2>What's your number</h2>
                  <input class="form-control transparent-input" type="text" name="name" placeholder="Mobile or Phone number" required="" name="message_number" value="<?php echo esc_attr($_POST['message_number']); ?>"></input>
                </div>
              </div>
              <div class="col-md-12 modal-footer">
                <button type="button" class="btn btn-secondary" id="previous3">← Previous</button>
                <button type="button" class="btn btn-primary" id="next3">Next →</button>
              </div>
              <div class="col-md-12 dotstyle dotstyle-fillup">
                <ul>
                  <li class="current"><a href="#"></a></li>
                  <li class="current"><a href="#"></a></li>
                  <li class="current"><a href="#"></a></li>
                  <li><a href="#"></a></li>
                </ul>
              </div>
            </div>
            <div class="modal-content contact-modal-4" style="display: none">
              <div class="col-md-12 modal-header">
                <h1 class="modal-title">Contact Us</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: white; font-size: 50px;">&times;</span>
                </button>
              </div>
              <div class="col-md-12 modal-body">
                <div class="col-md-2 contact-modal-number">04</div>
                <div class="col-md-10">
                  <h2>How can we help you?</h2>
                  <textarea class="form-control transparent-input" type="text" name="message_text" placeholder="Describe in a few words..." required="" <?php echo esc_textarea($_POST['message_text']); ?>></textarea>
                </div>
              </div>
              <div class="col-md-12 modal-footer">
                <button type="button" class="btn btn-secondary" id="previous4">← Previous</button>
                <button type="submit" class="btn btn-primary" id="next4">Submit →</button>
              </div>
              <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <div class="container">
                <div class="home1">
                  <p><?php the_content(); ?></p>
                </div>
              </div>
              <?php endwhile; endif; ?>
              <div class="col-md-12 dotstyle dotstyle-fillup">
                <ul>
                  <li class="current"><a href="#"></a></li>
                  <li class="current"><a href="#"></a></li>
                  <li class="current"><a href="#"></a></li>
                  <li class="current"><a href="#"></a></li>
                </ul>
              </div>
            </div>
            <div id="modal-background" class="modal-content contact-confirmation" style="display: none;">
              <div class="col-md-12 modal-header">
                <h1 class="modal-title">Thank you!</h1>
                <?php echo $response; ?>
              </div>
              <div class="col-md-12 modal-body">
                <img class="center" src="<?php bloginfo('template_url');?>/images/Mail.png" srcset="<?php bloginfo('template_url');?>/images/Mail.png 1x,<?php bloginfo('template_url');?>/images/Mail@2x.png 2x" alt="innovatech">
                <h2>Your message has been successfully sent!<br/>We aim to get back to you within one working day.</h2>
              </div>
              <div class="col-md-12 modal-footer">
                <button type="button" class="btn btn-primary" id="end" class="close" data-dismiss="modal">Back to site</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
    jQuery(document).ready(function () {
      jQuery("#next1").click(function () {
        jQuery(".contact-modal-1").hide();
        jQuery(".contact-modal-2").show();
      });
      jQuery("#next2").click(function () {
        jQuery(".contact-modal-2").hide();
        jQuery(".contact-modal-3").show();
      });
      jQuery("#next3").click(function () {
        jQuery(".contact-modal-3").hide();
        jQuery(".contact-modal-4").show();
      });
      jQuery("#next4").click(function () {
        jQuery(".contact-modal-4").hide();
        jQuery(".contact-confirmation").show();
      });
      jQuery("#previous2").click(function () {
        jQuery(".contact-modal-2").hide();
        jQuery(".contact-modal-1").show();
      });
      jQuery("#previous3").click(function () {
        jQuery(".contact-modal-3").hide();
        jQuery(".contact-modal-2").show();
      });
      jQuery("#previous4").click(function () {
        jQuery(".contact-modal-4").hide();
        jQuery(".contact-modal-3").show();
      });
      jQuery("#end").click(function () {
        setTimeout(function () {
          jQuery(".contact-confirmation").hide();
          jQuery(".contact-modal-1").show();
        }, 500);
      });
    });
  </script>
<?php get_footer(); ?>