<?php

namespace Stageo\Lib\Security;

use Exception;
use Stageo\Lib\enums\Action;
use Stageo\Lib\Mailer\Email;
use Stageo\Lib\Mailer\Mailer;
use Stageo\Model\Object\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailVerification
{
    const VERIFICATION_HOURS_TIMEOUT = 48;

    /**
     * @throws Exception
     */
    public static function sendVerificationEmail(string $email): string
    {
        $nonce = Token::generateToken(16);
        $data = Crypto::encrypt([
            "email" => $email,
            "nonce" => $nonce
        ]);
        $url = $_ENV["ABSOLUTE_URL"] . Action::ENTREPRISE_VERIFIER->value . "&data=$data";

        Mailer::send(new Email(
            destinataire: $email,
            objet: "Verify your email",
            message: "<a href='$url'>Vérifier mon email</a>"
        ));
        return $nonce;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public static function sendAlertEmail(string $email): void
    {
        Mailer::send(new Email(
            destinataire: $email,
            objet: "Votre email a été utilisé pour s'inscrire",
            message: "Si vous n'êtes pas à l'origine de cette action, veuillez contacter l'administrateur du site."
        ));
    }

    public static function verify(?User  $user,
                                  string $nonce): bool
    {
        return !is_null($user) and $nonce === $user->getNonce();
    }

    public static function isTimeout(int $timestamp,
                                     int $hours = self::VERIFICATION_HOURS_TIMEOUT): bool
    {
        return time() >= $timestamp + $hours * 3600;
    }
}