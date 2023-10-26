<?php

namespace Stageo\Lib\Security;

use Stageo\Lib\enums\Pattern;

class Validate
{
    private static function match(string $pattern, string $subject, bool $required): bool
    {
        return $required
            ? preg_match("/" . $pattern . "/", $subject)
            : preg_match("/" . $pattern . "/", $subject) or empty($subject);
    }

    public static function isName(string $name, bool $required = true): bool
    {
        return self::match(
            pattern: Pattern::NAME->value,
            subject: $name,
            required: $required);
    }

    public static function isText(string $text, bool $required = false): bool
    {
        return self::match(
            pattern: Pattern::TEXT->value,
            subject: $text,
            required: $required);
    }

    public static function isFloat(string $float, bool $required = true): bool
    {
        return self::match(
            pattern: Pattern::FLOAT->value,
            subject: $float,
            required: $required);
    }

    public static function isEmail(string $email, bool $required = true): bool
    {
        return self::match(
            pattern: Pattern::EMAIL->value,
            subject: $email,
            required: false);
    }

    public static function isPassword(string $password, bool $required = true): bool
    {
        return self::match(
            pattern: Pattern::PASSWORD->value,
            subject: $password,
            required: $required);
    }

    public static function isUrl(string $url, bool $required = false): bool
    {
        return self::match(
            pattern: Pattern::URL->value,
            subject: $url,
            required: $required);
    }

    public static function isStudentId(string $studentId, bool $required = false): bool
    {
        return self::match(
            pattern: Pattern::ID_ETUDIANT->value,
            subject: $studentId,
            required: $required);
    }

    public static function isSiret(string $siret, bool $required = true): bool
    {
        return self::match(
            pattern: Pattern::SIRET->value,
            subject: $siret,
            required: $required);
    }

    public static function isPhoneNumber(string $phone, bool $required = false): bool
    {
        return self::match(
            pattern: Pattern::PHONE_NUMBER->value,
            subject: $phone,
            required: $required);
    }

    public static function isCodeNaf(string $codeNaf, bool $required = false): bool
    {
        return self::match(
            pattern: Pattern::NAF->value,
            subject: $codeNaf,
            required: $required);
    }
}