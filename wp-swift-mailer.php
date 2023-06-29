<?php
/**
 * Plugin name: WP Swift Mailer
 * Description: Simple implementation of Swift Mailer for Wordpress.
 * Version: 1.1.0
 * Author: AimToFeel
 * Author URI: https://aimtofeel.com
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text domain: wp-swift-mailer
 */

use WPSwiftMailer\src\WPSwiftMailer;

if (!function_exists('add_action')) {
    die('Not allowed to call WP Swift Mailer directly.');
}

define('WP_SWIFT_MAILER_DIRECTORY', plugin_dir_path(__FILE__));
require_once WP_SWIFT_MAILER_DIRECTORY . 'src/WPSwiftMailer.php';
require_once WP_SWIFT_MAILER_DIRECTORY . 'src/WPSwiftMailerException.php';

$wpSwiftMailer = new WPSwiftMailer();
add_action('init', [$wpSwiftMailer, 'onInit']);

/**
 * Override wp mail functionality and call wp swift mailer implementation.
 *
 * @param string $recipient
 * @param string $subject
 * @param string $message
 * @param array $headers
 * @param array $attachments
 *
 * @return bool
 *
 * @author Niek van der Velde <niek@aimtofeel.com>
 * @version 1.0.0
 */
if (!function_exists('wp_mail')) {
    function wp_mail(
        $recipient,
        $subject,
        $message,
        $headers = [],
        $attachments = []
    ): bool{
        do_action('wp_swift_mailer_send', [
            'recipient' => $recipient,
            'subject' => $subject,
            'message' => $message,
            'headers' => $headers,
            'attachments' => $attachments,
        ]);

        return true;
    }
}
