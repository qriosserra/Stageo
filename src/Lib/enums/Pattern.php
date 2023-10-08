<?php

namespace Stageo\Lib\enums;

enum Pattern: string
{
    case EMAIL = "\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b";
    case PASSWORD = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,64}$";
    case URL = "[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?";
    case ID_ETUDIANT = "[0-9]{8}";

    public static function toArray(): array
    {
        foreach (self::cases() as $pattern) {
            $patterns[lcfirst(str_replace("_", "", ucwords(strtolower($pattern->name), "_")))] = $pattern->value;
        }
        return $patterns ?? [];
    }
}