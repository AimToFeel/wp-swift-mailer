<?php

namespace WPSwiftMailer\src;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
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

        $this->transporter = Transport::fromDsn('smtp://' . WP_SWIFT_MAILER_SMTP_USERNAME . ':' . WP_SWIFT_MAILER_SMTP_PASSWORD . '@' . WP_SWIFT_MAILER_SMTP_HOST . ':' . WP_SWIFT_MAILER_SMTP_PORT . '?encryption=' . WP_SWIFT_MAILER_SMTP_ENCRYPTION);
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
        $recipients = is_array($parameters['recipient'])
        ? $parameters['recipient']
        : [];

        if (count($recipients) === 0) {
            $recipients = preg_split('/([;,\s])+/', $parameters['recipient']);
        }

        $mailer = new Mailer($this->transporter);

        $email = (new Email())
            ->from(WP_SWIFT_MAILER_SENDER)
            ->to($recipients)
            ->subject($parameters['subject'])
            ->html($parameters['message']);

        if (isset($parameters['headers']['Reply-To'])) {
            $email = $email->replyTo($parameters['headers']['Reply-To']);
        }

        $mailer->send($email);
    }
}
