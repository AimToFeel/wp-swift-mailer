# Wordpress Swift Mailer
Replaces default `wp_mail(...)` implementation with Swift Mailer support. Which will allow your website to send emails trough SMTP servers with ease.

## Installation
This plugin can be installed with composer, not sure how to use Wordpress in combination with a package manager, take a look at [Roots/Bedrock](https://roots.io/bedrock/).

1. Require the package: `composer require aimtofeel/wp-swift-mailer`
2. Apply WP Swift Mailer configuration, and setup for example a SMTP connection 

## Configuration
To be able the start sending mail through Swift mailer we need to setup somethings. This package uses constants to setup the right values for you. The supported constants are listed below:

### `WP_SWIFT_MAILER_TRANSPORTER`
*Required*

Possible values:
* `smtp`

Currently this package only supports SMTP, just because I needed SMTP connectivity and don't really care about other transporters for now. But hey, if you want to help out and implement other Swift Mailer transporters feel free to submit a PR. 

### `WP_SWIFT_MAILER_SENDER`
*Required*

Define from which email address you would like to send mail from. For example: `no-reply@example.com`

### `WP_SWIFT_MAILER_SMTP_HOST`
*Required when using the SMTP transporter*

Define your SMTP host. For example when using Gmail: `smtp.gmail.com`.

### `WP_SWIFT_MAILER_SMTP_PORT`
*Required when using the SMTP transporter*

Define the port of the SMTP server. For example when using Gmail: `587`.

### `WP_SWIFT_MAILER_SMTP_ENCRYPTION`
*Required when using the SMTP transporter*

Encryption type of the SMTP connection. For example when using Gmail: `tls`. 

### `WP_SWIFT_MAILER_SMTP_USERNAME`
*Not required, but probably needed when using SMTP transporter*

The username of which you will be able to sign into the SMTP server. When using Gmail this is your email address. 

### `WP_SWIFT_MAILER_SMTP_PASSWORD`
*Not required, but probably needed when using SMTP transporter*

The password of which you will be able to sign into the SMTP server. When using Gmail this is your Gmail password. 

#### Configuration example
Using Roots wp config:
```php
Config::define('WP_SWIFT_MAILER_TRANSPORTER', 'smtp');
Config::define('WP_SWIFT_MAILER_SENDER', env('MAIL_SENDER'));
Config::define('WP_SWIFT_MAILER_SMTP_HOST', env('SMTP_HOST'));
Config::define('WP_SWIFT_MAILER_SMTP_PORT', env('SMTP_PORT'));
Config::define('WP_SWIFT_MAILER_SMTP_ENCRYPTION', env('SMTP_ENCRYPTION'));
Config::define('WP_SWIFT_MAILER_SMTP_USERNAME', env('SMTP_USERNAME'));
Config::define('WP_SWIFT_MAILER_SMTP_PASSWORD', env('SMTP_PASSWORD'));
```

Using pure php:
```php
define('WP_SWIFT_MAILER_TRANSPORTER', 'smtp');
define('WP_SWIFT_MAILER_SENDER', env('MAIL_SENDER'));
define('WP_SWIFT_MAILER_SMTP_HOST', env('SMTP_HOST'));
define('WP_SWIFT_MAILER_SMTP_PORT', env('SMTP_PORT'));
define('WP_SWIFT_MAILER_SMTP_ENCRYPTION', env('SMTP_ENCRYPTION'));
define('WP_SWIFT_MAILER_SMTP_USERNAME', env('SMTP_USERNAME'));
define('WP_SWIFT_MAILER_SMTP_PASSWORD', env('SMTP_PASSWORD'));
```

## Improvements list
* Add support for more Swift Mailer transporters
* Add support for mail attachments

## Open to code submission
I'm always open to PR's. For example this package currently only supports the SMTP transporter, but it would be nice to support all Swift Mailer transporters. If you have some time on your hands and want to contribute, feel free to submit a PR.

## Author
This package is created by [AimToFeel](https://aimtofeel.com).

## License
[GPLv2](https://www.gnu.org/licenses/gpl-2.0.html)
