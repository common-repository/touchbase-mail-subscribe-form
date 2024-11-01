<?php

/***
 * Script registration for lazy loading
 * https://mikejolley.com/2013/12/02/sensible-script-enqueuing-shortcodes/
 */
add_action('wp_enqueue_scripts', 'touchbasemail_register_script');
function touchbasemail_register_script()
{
  wp_register_script('touchbasemail-shortcode', plugins_url('../js/shortcode.js', __FILE__), array(), TOUCHBASEMAIL_PLUGIN_VERSION, true);
}

// Style registration
wp_register_style('touchbasemail-shortcode', plugins_url('../css/shortcode.css', __FILE__), array(), TOUCHBASEMAIL_PLUGIN_VERSION, 'screen');
wp_register_style('touchbasemail-shortcode-wide', plugins_url('../css/shortcode-wide.css', __FILE__), array(), TOUCHBASEMAIL_PLUGIN_VERSION, 'screen');
wp_register_style('touchbasemail-shortcode-vertical', plugins_url('../css/shortcode-vertical.css', __FILE__), array(), TOUCHBASEMAIL_PLUGIN_VERSION, 'screen');

// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');

/***
 * Main shortcode function, hands off to separate styles
 */
add_shortcode('touchbase_subscribe_form', 'touchbasemail_subscribe_form_creation');
function touchbasemail_subscribe_form_creation( $atts )
{
  // Make sure jquery is loaded
  wp_enqueue_script('jquery');
  wp_enqueue_script('touchbasemail-shortcode');
  wp_enqueue_style('touchbasemail-shortcode');

  $pull_quote_atts = shortcode_atts( array(
    'format' => 'wide',
  ), $atts );

  // Choose which css is required for this form
  switch($pull_quote_atts['format']) {
    case 'vertical':
      wp_enqueue_style('touchbasemail-shortcode-vertical');
      break;
    case 'wide':
    default:
      wp_enqueue_style('touchbasemail-shortcode-wide');
      $pull_quote_atts['format'] = 'wide';
  }

  return touchbasemail_subscribe_form_html( $pull_quote_atts );
}

/***
 * Generates the form HTML with a format class to specify which type.
 *
 * @param $attr array Shortcode attributes
 * @return string HTML output
 */
function touchbasemail_subscribe_form_html( $attr )
{
  // Grab admin settings options
  $options = get_option('touchbasemail_subscribe_form');

  // Override defaults with shortcode attributes
  $options['public_token'] = empty( $attr['public_token'] ) ? $options['public_token'] : $attr['public_token'];
  $options['list_id'] = empty( $attr['list'] ) ? $options['list_id'] : $attr['list'];

  // Use ob so the shortcode content shows up in the right place
  ob_start();
  ?>
  <form class="touchbasemail-subscribe-form touchbasemail-subscribe-form-format-<?php echo $attr['format']; ?>">
    <div>
      <!-- Hidden fields for API call -->
      <input name="public_token" type="hidden" value="<?php echo $options['public_token']; ?>">
      <input name="list" type="hidden" value="<?php echo $options['list_id']; ?>">

      <!-- Visible form elements -->
      <input type='email' name="email" placeholder="<?php _e('Email Address', TOUCHBASEMAIL_PLUGIN_ID); ?>"/>
      <input type="submit" value="<?php _e('Subscribe!', TOUCHBASEMAIL_PLUGIN_ID); ?>"/>

      <div style="clear:both;"></div>
    </div>

    <!-- error message -->
    <div class='touchbasemail-subscribe-form-error' style='display:none;'>
      <?php _e('Unable to subscribe.', TOUCHBASEMAIL_PLUGIN_ID); ?>
      <span class="touchbasemail-subscribe-form-error-response">
        <?php _e('Email address required.', TOUCHBASEMAIL_PLUGIN_ID); ?>
      </span>
    </div>

    <!-- success message -->
    <div class='touchbasemail-subscribe-form-success' style='display:none;'>
      <?php _e('Subscribed successfully.', TOUCHBASEMAIL_PLUGIN_ID); ?>
    </div>
  </form>
  <?php
  return ob_get_clean();
}
