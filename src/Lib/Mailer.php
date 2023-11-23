<?php

namespace Stageo\Lib;

class Mailer
{
    /**
     * @param Email $email
     * @return bool
     */
    public static function send(Email $email): bool
    {
        $header = <<<EOD
            From: "Stageo" {$_ENV["MAILER_USER"]}
            Content-Type: text/html; charset=UTF-8
            MIME-Version: 1.0
            X-Mailer: PHP/8.1.0
        EOD;

        return mail(
            to: $email->getDestinataire(),
            subject: $email->getObjet(),
            message: $email->getContenu(),
        );
    }
}