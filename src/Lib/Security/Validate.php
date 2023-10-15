<?php

namespace Stageo\Lib\Security;

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

    public static function isStudentId(string $studentId): bool
    {
        return preg_match(
            pattern: "/" . Pattern::ID_ETUDIANT->value . "/",
            subject: $studentId
        );
    }

    public static function isSiret(string $siret): bool
    {
        return preg_match(
            pattern: "/" . Pattern::SIRET->value . "/",
            subject: $siret
        );
    }

    public static function isPhone(string $phone): bool
    {
        return preg_match(
            pattern: "/" . Pattern::PHONE->value . "/",
            subject: $phone
        );
    }

    public static function isFax(string $fax): bool
    {
        return preg_match(
            pattern: "/" . Pattern::PHONE->value . "/",
            subject: $fax
        );
    }

    public static function isRaisonSociale(string $raisonSociale): bool
    {
        return preg_match(
            pattern: "/" . Pattern::NAME->value . "/",
            subject: $raisonSociale
        );
    }

    public static function isAdresse(string $adresse): bool
    {
        return preg_match(
            pattern: "/" . Pattern::NAME->value . "/",
            subject: $adresse
        );
    }

    public static function isCodePostal(string $codePostal): bool
    {
        return preg_match(
            pattern: "/" . Pattern::CODE_POSTAL->value . "/",
            subject: $codePostal
        );
    }

    public static function isCodeNaf(string $codeNaf): bool
    {
        return preg_match(
            pattern: "/" . Pattern::NAF->value . "/",
            subject: $codeNaf
        );
    }

    public static function isStatutJuridique(string $statutJuridique): bool
    {
        return preg_match(
            pattern: "/" . Pattern::NAME->value . "/",
            subject: $statutJuridique
        );
    }

    public static function isEffectif(string $effectif): bool
    {
        return preg_match(
            pattern: "/" . Pattern::NUMBER->value . "/",
            subject: $effectif
        );
    }

    public static function isTypeStructure(string $typeStructure): bool
    {
        return preg_match(
            pattern: "/" . Pattern::NAME->value . "/",
            subject: $typeStructure
        );
    }
}