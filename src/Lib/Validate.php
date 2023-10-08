<?php

namespace Stageo\Lib;

use Stageo\Lib\enums\Pattern;

class Validate
{
    public static function isEmail(string $email): bool
    {
        return preg_match(
            pattern: "/" . Pattern::EMAIL->value . "/",
            subject: $email
        );
    }

    public static function isPassword(string $password): bool
    {
        return preg_match(
            pattern: "/" . Pattern::PASSWORD->value . "/",
            subject: $password
        );
    }

    public static function isUrl(string $url): bool
    {
        return preg_match(
            pattern: "/" . Pattern::URL->value . "/",
            subject: $url
        );
    }

    public static function isStudentId(string $studentId)
    {
        return preg_match(
            pattern: "/" . Pattern::ID_ETUDIANT->value . "/",
            subject: $studentId
        );
    }
}