<?php

namespace Stageo\Lib\enums;

enum Pattern: string
{
    case NAME = ".{1,256}";
    case TEXT = "(.|\n){1,3064}";
    case NUMBER = "[0-9]{1,64}";
    case FLOAT = "[0-9]{1,64}\.[0-9]{1,2}";
    case EMAIL = "\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b";
    case PASSWORD = "*"; //"^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,64}$";
    case URL = "^(https?:\/\/)?([\da-z\.-]+\.[a-z\.]{2,6}|[\d\.]+)([\/:?=&#]{1}[\da-z\.-]+)*[\/\?]?$";
    case ID_ETUDIANT = "[0-9]{8}";
    case SIRET = "[0-9]{14}";
    case PHONE_NUMBER = "^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$";
    case CODE_POSTAL = "[0-9]{5}";
    case NAF = "[0-9]{4}[A-Z]{1}";

    public static function toArray(): array
    {
        foreach (self::cases() as $pattern) {
            $patterns[lcfirst(str_replace("_", "", ucwords(strtolower($pattern->name), "_")))] = $pattern->value;
        }
        return $patterns ?? [];
    }
}