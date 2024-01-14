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
        return $required ? is_numeric($float) : (empty($float) || is_numeric($float));
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

    public static function isDate(string $date, bool $required = true): bool
    {
        return self::match(
            pattern: Pattern::DATE->value,
            subject:$date,
            required:$required);
    }

    public static function isDateStage(string $debut, string $fin, string $niveau) {
        // Date debut correcte
        if (!self::isDate($debut) || !self::isDate($fin)) {
            return false;
        }

        $date_debut = date('Y-m-d', strtotime($debut));
        $date_fin = date('Y-m-d', strtotime($fin));

        // Obtenir l'année de stage
        $anneeStage = date('Y', strtotime($debut));
        // Année actuelle
        $annee = date('Y');

        if ($anneeStage - $annee > 1 || $anneeStage - $annee < 0) {
            return false;
        }

        if ($niveau == 'BUT2') {
            if ($date_fin > date('Y-m-d', strtotime("$anneeStage-07-05")) || $date_debut < date('Y-m-d', strtotime("$anneeStage-04-08"))) {
                return false;
            }
        } else {
            if ($date_fin > date('Y-m-d', strtotime("$anneeStage-08-28")) || $date_debut < date('Y-m-d', strtotime("$anneeStage-03-25"))) {
                return false;
            }
        }

        switch ($niveau) {
            case 'BUT2':
                $baseDate = $date_debut;
                $minDate = date('Y-m-d', strtotime("+10 weeks", strtotime($baseDate)));
                $maxDate = date('Y-m-d', strtotime("+10 weeks", strtotime($baseDate)));
                $extensionDate = date('Y-m-d', strtotime("+12 weeks", strtotime($baseDate)));
                break;

            case 'BUT3':
                $baseDate = $date_debut;
                $minDate = date('Y-m-d', strtotime("+16 weeks", strtotime($baseDate)));
                $maxDate = date('Y-m-d', strtotime("+16 weeks", strtotime($baseDate)));
                $extensionDate = date('Y-m-d', strtotime("+20 weeks", strtotime($baseDate)));
                break;

            case 'BUT2&BUT3':
                $baseDate = $date_debut;
                $minDate = date('Y-m-d', strtotime("+10 weeks", strtotime($baseDate)));
                $maxDate = date('Y-m-d', strtotime("+20 weeks", strtotime($baseDate)));
                $extensionDate = date('Y-m-d', strtotime("+20 weeks", strtotime($baseDate)));
                break;

            default:
                return false;
        }

        // Date fin dans les clous
        if ($date_fin > $maxDate && $date_fin > $extensionDate) {
            return false;
        }

        return true;
    }



    public static function isNiveau(string $niveau, bool $required = true):bool
    {
        $niveauxtab = ["BUT2", "BUT3", "BUT2&BUT3", "BUT3&BUT2"];

        if ($required && !in_array($niveau, $niveauxtab)) {
            return false;
        }

        return true;
    }

    public static function isGratification(float $gratification, bool $required=true):bool
    {
       if(!self::isFloat($gratification) || $gratification<4.35){
           return false;
       }
       return true;
    }
}