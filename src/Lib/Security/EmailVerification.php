<?php

namespace Stageo\Lib\Security;

use Exception;
use Stageo\Lib\Mailer;
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
        $absoluteURL = $_ENV["ABSOLUTE_URL"];
        $nonce = Token::generateToken(16);
        $encodedData = Crypto::encrypt([
            "email" => $email,
            "nonce" => $nonce
        ]);
        $url = "$absoluteURL/verify/$encodedData";

        Mailer::send(
            to: $email,
            subject: "Verify your email",
            content: "<a href='$url'>Verify your email</a>"
        );
        return $nonce;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public static function sendAlertEmail(string $email): void
    {
        Mailer::send(
            to: $email,
            subject: "Your email has been used to sign up",
            content: ""
        );
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