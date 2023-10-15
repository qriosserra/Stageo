<?php

namespace Stageo\Lib\enums;

enum Pattern: string
{
    case EMAIL = "\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b";
    case PASSWORD = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,64}$";
    case URL = "[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?";
    case ID_ETUDIANT = "[0-9]{8}";
    case SIRET = "[0-9]{14}";
    case PHONE = "[0-9]{10}";
    case NAME = "[a-zA-ZÀ-ÿ-]{2,64}";
    case NUMBER = "[0-9]{1,64}";
    case CODE_POSTAL = "[0-9]{5}";
    case NAF = "[0-9]{4}[A-Z]{1}";
    case THEMATIQUE = "^.{1,50}$";
    case SECTEUR = "^.{1,100}$";
    case DESCRIPTION = "^.{1,500}$";
    case UNITEGRATIFICATION = "[A-Z]{1,5}";


    public static function toArray(): array
    {
        foreach (self::cases() as $pattern) {
            $patterns[lcfirst(str_replace("_", "", ucwords(strtolower($pattern->name), "_")))] = $pattern->value;
        }
        return $patterns ?? [];
    }
}