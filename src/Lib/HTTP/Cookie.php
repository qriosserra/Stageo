<?php

namespace Stageo\Lib\HTTP;

class Cookie
{
    public static function set(string $key,
                               string $value,
                               ?int   $expirationTime = null): void
    {
        if (is_null($expirationTime)) setcookie($key, serialize($value));
        else                          setcookie($key, serialize($value), $expirationTime);
    }

    public static function get(string $key,
                               bool   $delete = false): ?string
    {
        $value = unserialize($_COOKIE[$key]);
        if ($delete) self::delete($key);
        return $value;
    }

    public static function contains($key): bool
    {
        return isset($_COOKIE[$key]);
    }

    public static function delete($key): void
    {
        unset($_COOKIE[$key]);
        setcookie($key, "", 1);
    }
}