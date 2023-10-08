<?php

namespace Stageo\Lib\HTTP;

use Exception;

class Session
{
    private static bool $hasSessionStarted = false;

    /**
     * This function is used at the start of every functions of this class to ensure that Session has been started.
     */
    private function startSession(): void
    {
        if (!self::$hasSessionStarted and !session_start())
            throw new Exception("Session could not start.");
        elseif (!self::$hasSessionStarted)
            self::$hasSessionStarted = true;
    }

    public static function contains(string $key): bool
    {
        (new Session)->startSession();
        return isset($_SESSION[$key]);
    }

    public static function set(string $key,
                               mixed  $value): mixed
    {
        (new Session)->startSession();
        $_SESSION[$key] = $value;
        return $value;
    }

    public static function get(string $key,
                               bool   $delete = false): mixed
    {
        (new Session)->startSession();
        $value = $_SESSION[$key] ?? null;
        if ($delete) self::delete($key);
        return $value;
    }

    public static function delete(string $key): void
    {
        (new Session)->startSession();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        (new Session)->startSession();
        /**
         * unset $_SESSION variable for the run-time
         */
        session_unset();
        /**
         * destroy session data in storage
         */
        session_destroy();
        /**
         * deletes the session cookie
         */
        Cookie::delete(session_name());
        self::$hasSessionStarted = false;
    }

//    public static function verifierDerniereActivite(): void
//    {
//        if (isset($_SESSION['derniereActivite']) && time() - $_SESSION['derniereActivite'] > $dureeExpiration) {
//            session_unset(); //unsets $_SESSION variable for the run-time
//        }
//        $_SESSION['derniereActivite'] = time(); //update last activity time stamp
//    }
}