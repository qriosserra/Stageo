<?php

namespace Stageo\Lib\Security;

use Stageo\Lib\enums\RouteName;
use Stageo\Lib\HTTP\Session;

class Token
{
    const TOKEN_PREFIX = "token_";
    const TIMESTAMP_PREFIX = "timestamp_";

    /**
     * Generates a string of 22 characters by default to have more than 256 random bits. (a characters is encoded
     * on 6 bits in 64 base)
     */
    public static function generateToken(string|RouteName $key,
                                         int              $length = 43): string
    {
        $randomBytes = random_bytes(ceil($length * 6 / 8));
        $nonce = substr(Crypto::encode($randomBytes), 0, $length);
        Session::set(
            key: is_string($key) ? self::TIMESTAMP_PREFIX . $key : self::TIMESTAMP_PREFIX . $key->value,
            value: time()
        );
        return Session::set(
            key: is_string($key) ? self::TOKEN_PREFIX . $key : self::TOKEN_PREFIX . $key->value,
            value: $nonce
        );
    }

    public static function get(string|RouteName $key): string
    {
        return Session::get(is_string($key) ? self::TOKEN_PREFIX . $key : self::TOKEN_PREFIX . $key->value);
    }

    public static function delete(string|RouteName $key): void
    {
        Session::delete(is_string($key) ? self::TOKEN_PREFIX . $key : self::TOKEN_PREFIX . $key->value);
    }

    public static function verify(string|RouteName $key,
                                  string           $token,
                                  bool             $delete = true): bool
    {
        return $token === Session::get(
                key: is_string($key) ? self::TOKEN_PREFIX . $key : self::TOKEN_PREFIX . $key->value,
                delete: $_ENV["DEBUG"] ? false : $delete
            );
    }

    public static function isTimeout(string|RouteName $key,
                                     bool             $delete = true,
                                     int              $minutes = 60): bool
    {
        $timestamp = Session::get(
            key: is_string($key) ? self::TIMESTAMP_PREFIX . $key : self::TIMESTAMP_PREFIX . $key->value,
            delete: $_ENV["DEBUG"] ? false : $delete
        );
        return time() >= $timestamp + $minutes * 60;
    }
}