<?php

namespace Stageo\Lib;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\RawMessage;

class Mailer implements MailerInterface
{
    /**
     * @throws TransportExceptionInterface
     */
    public static function sendEmail(string $to,
                                     string $subject,
                                     string $content): void
    {
        $email = (new TemplatedEmail())
            ->from($_ENV["MAILER_USER"])
            ->to($to)
            ->subject($subject)
            ->text('Sending emails is fun again!')
            ->html($content);
        (new Mailer)->send($email);
    }

    /**
     * @param RawMessage $message
     * @param Envelope|null $envelope
     * @return void
     * @throws TransportExceptionInterface
     */
    public function send(RawMessage $message,
                         Envelope   $envelope = null): void
    {
        $transport = Transport::fromDsn($_ENV["MAILER_DSN"]);
        $transport->send($message, $envelope);
    }
}