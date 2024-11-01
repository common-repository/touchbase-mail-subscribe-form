<?php
/*
Plugin Name: TouchBase Mail Subscribe Form
Plugin URI:  https://touchbasemail.com
Description: Adds a form to allow your followers to subscribe to your TouchBase mailing lists.
Version:     1.0.1
Author:      TouchBase Mail
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: touchbasemail-subscribe-form
*/

define('TOUCHBASEMAIL_PLUGIN_ID', 'touchbasemail-subscribe-form');
define('TOUCHBASEMAIL_PLUGIN_VERSION', '1.0.2');

/*
 * Additional Notes:
 * - To get the minimum required wordpress version: https://wpseek.com/pluginfilecheck/
 * - Readme validator: https://wordpress.org/plugins/about/validator/
 */

// Admin Options
if (is_admin()) {
  include(plugin_dir_path(__FILE__) . 'includes/options.php');
}

// Shortcode
include(plugin_dir_path(__FILE__) . 'includes/shortcode.php');
