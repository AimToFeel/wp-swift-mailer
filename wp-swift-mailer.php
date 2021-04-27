<?php
/**
 * Plugin name: WP Swift Mailer
 * Description: Simple implementation of Swift Mailer for Wordpress.
 * Version: 1.0.0
 * Author: AimToFeel
 * Author URI: https://aimtofeel.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text domain: wp-swift-mailer
 */

if (!function_exists('add_action')) {
    die('Not allowed to call WP Swift Mailer directly.');
}

define('WP_SWIFT_MAILER_DIRECTORY', plugin_dir_path(__FILE__));

register_activation_hook(__FILE__, ['WPSwiftMailer', 'onPluginActivation']);
register_deactivation_hook(__FILE__, ['WPSwiftMailer', 'onPluginDeactivation']);

require_once WP_SWIFT_MAILER_DIRECTORY . 'src/WPSwiftMailer.php';

add_action('init', ['WPSwiftMailer', 'onInit']);
