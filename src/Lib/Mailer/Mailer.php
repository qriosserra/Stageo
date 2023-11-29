<?php

namespace Stageo\Lib\Mailer;

use Exception;
use Stageo\Controller\Exception\ControllerException;

class Mailer
{
    /**
     * @throws ControllerException
     */
    public static function send(Email $email): void
    {
        $mailer = new PHPMailer(true);
        $mailer->isSMTP();
        $mailer->SMTPAuth   = true;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Host       = $_ENV["MAILER_HOST"];
        $mailer->Username   = $_ENV["MAILER_USER"];
        $mailer->Password   = $_ENV["MAILER_PASSWORD"];
        $mailer->Port       = $_ENV["MAILER_PORT"];
        $mailer->Subject = $email->getObjet();
        $mailer->msgHTML($email->getMessage());
        try {
            $mailer->setFrom($mailer->Username, "Stageo");
            $mailer->addAddress($email->getDestinataire());
            $mailer->send();
        } catch (Exception $e) {
            throw new ControllerException($mailer->ErrorInfo);
        }
    }
}