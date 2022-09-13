<?php

namespace WPSwiftMailer\src;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use WPSwiftMailer\src\WPSwiftMailerException;

class WPSwiftMailer
{
    private $transporter;

    /**
     * On qp swift mailer on init.
     *
     * @return void
     *
     * @author Niek van der Velde <niek@aimtofeel.com>
     * @version 1.0.0
     */
    public function onInit(): void
    {
        $this->createTransport();

        add_action('wp_swift_mailer_send', [$this, 'sendMail']);
    }

    /**
     * Check if constant is defined.
     *
     * @param string $name
     *
     * @throws WPSwiftMailerException
     *
     * @return void
     *
     * @author Niek van der Velde <niek@aimtofeel.com>
     * @version 1.0.0
     */
    private function checkIfConstantIsDefined(string $name): void
    {
        if (!defined($name)) {
            throw new WPSwiftMailerException("Constant '{$name}' not defined, but the constant is required with this configuration.");
        }
    }

    /**
     * Create swift mailer transporter.
     *
     * @return void
     *
     * @author Niek van der Velde <niek@aimtofeel.com>
     * @version 1.0.0
     */
    private function createTransport(): void
    {
        $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_TRANSPORTER');
        $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_SENDER');

        switch (WP_SWIFT_MAILER_TRANSPORTER) {
            case 'smtp':
                $this->createSmtpTransporter();
                break;
            default;
                $transporterType = WP_SWIFT_MAILER_TRANSPORTER;
                throw new WPSwiftMailerException("Defined wp swift mailer transporter type not supported: {$transporterType}");
                break;
        }
    }

    /**
     * Create swift mailer SMTP transporter.
     *
     * @return void
     *
     * @author Niek van der Velde <niek@aimtofeel.com>
     * @version 1.0.0
     */
    private function createSmtpTransporter(): void
    {
        $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_SMTP_HOST');
        $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_SMTP_PORT');
        $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_SMTP_ENCRYPTION');

        $this->transporter = new Swift_SmtpTransport(
            WP_SWIFT_MAILER_SMTP_HOST,
            WP_SWIFT_MAILER_SMTP_PORT,
            WP_SWIFT_MAILER_SMTP_ENCRYPTION
        );

        try {
            $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_SMTP_USERNAME');
            $this->transporter->setUsername(WP_SWIFT_MAILER_SMTP_USERNAME);
        } catch (WPSwiftMailerException $exception) {}

        try {
            $this->checkIfConstantIsDefined('WP_SWIFT_MAILER_SMTP_PASSWORD');
            $this->transporter->setPassword(WP_SWIFT_MAILER_SMTP_PASSWORD);
        } catch (WPSwiftMailerException $exception) {}
    }

    /**
     * Send mail.
     *
     * @param array $parameters
     *
     * @return void
     *
     * @author Niek van der Velde <niek@aimtofeel.com>
     * @version 1.0.0
     */
    public function sendMail($parameters)
    {
        $swiftMessage = (new Swift_Message($parameters['subject']))
            ->setFrom([WP_SWIFT_MAILER_SENDER])
            ->setTo(is_array($parameters['recipient']) ? $parameters['recipient'] : [$parameters['recipient']])
            ->setBody($parameters['message']);

        if (isset($parameters['headers']['Content-type']) && strpos($parameters['headers']['Content-type'], 'text/html') > 0) {
            $swiftMessage->setContentType('text/html');
        }

        $mailer = new Swift_Mailer($this->transporter);
        $mailer->send($swiftMessage);
    }
}
