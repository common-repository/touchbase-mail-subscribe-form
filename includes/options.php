<?php

class TouchBaseMailSettingsPage
{
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;

  /**
   * Start up
   */
  public function __construct()
  {
    add_action('admin_menu', array($this, 'add_plugin_page'));
    add_action('admin_init', array($this, 'page_init'));
  }

  /**
   * Add options page
   */
  public function add_plugin_page()
  {
    // This page will be under "Settings"
    add_options_page(
      __('TouchBase Mail Settings', TOUCHBASEMAIL_PLUGIN_ID),
      __('TouchBase Mail', TOUCHBASEMAIL_PLUGIN_ID),
      'manage_options',
      TOUCHBASEMAIL_PLUGIN_ID,
      array($this, 'create_admin_page')
    );
  }

  /**
   * Options page callback
   */
  public function create_admin_page()
  {
    // Set class property
    $this->options = get_option('touchbasemail_subscribe_form');
    ?>
    <div class="wrap">
      <h1><?php _e('TouchBase Mail Settings', TOUCHBASEMAIL_PLUGIN_ID); ?></h1>
      <form method="post" action="options.php">
        <?php
        // This prints out all hidden setting fields
        settings_fields('touchbasemail_subscribe_form_group');
        do_settings_sections('touchbasemail_settings_admin');
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Register and add settings
   */
  public function page_init()
  {
    register_setting(
      'touchbasemail_subscribe_form_group', // Option group
      'touchbasemail_subscribe_form', // Option name
      array($this, 'sanitize') // Sanitize
    );

    add_settings_section(
      'touchbasemail_subscribe_form_section', // ID
      __('API Settings', TOUCHBASEMAIL_PLUGIN_ID), // Title
      array($this, 'print_section_info'), // Callback
      'touchbasemail_settings_admin' // Page
    );

    add_settings_field(
      'public_token',
      __('Public Token', TOUCHBASEMAIL_PLUGIN_ID),
      array($this, 'token_callback'),
      'touchbasemail_settings_admin',
      'touchbasemail_subscribe_form_section'
    );

    // TODO: Pull available lists from API
    add_settings_field(
      'list_id', // ID
      __('List ID', TOUCHBASEMAIL_PLUGIN_ID), // Title
      array($this, 'list_callback'), // Callback
      'touchbasemail_settings_admin', // Page
      'touchbasemail_subscribe_form_section' // Section
    );
  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize($input)
  {
    $new_input = array();

    if (isset($input['list_id']))
      $new_input['list_id'] = absint($input['list_id']);

    if (isset($input['public_token']))
      $new_input['public_token'] = sanitize_text_field($input['public_token']);

    return $new_input;
  }

  /**
   * Print the Section text
   */
  public function print_section_info()
  {
    print 'For details on how to collect this information <a target="_blank" href="https://clients.touchbasemail.net/help/6-remote-subscription-form">click here</a> or view the <strong>Additional Configuration</strong> section on the WordPress plugin page. Enter your API settings below:';
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function list_callback()
  {
    printf(
      '<input type="text" id="list_id" name="touchbasemail_subscribe_form[list_id]" value="%s" />',
      isset($this->options['list_id']) ? esc_attr($this->options['list_id']) : ''
    );
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function token_callback()
  {
    printf(
      '<input type="text" id="public_token" name="touchbasemail_subscribe_form[public_token]" value="%s" />',
      isset($this->options['public_token']) ? esc_attr($this->options['public_token']) : ''
    );
  }
}

if (is_admin())
  $my_settings_page = new TouchBaseMailSettingsPage();