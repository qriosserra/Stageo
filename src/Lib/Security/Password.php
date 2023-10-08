<?php

namespace Stageo\Lib\Security;

class Password
{
	private static string $pepper;

    private static function setPepper(): void
    {
        self::$pepper = $_ENV["PEPPER"];
    }

    public static function hash(string $password): string
	{
        self::setPepper();
        $pepperedPassword = hash_hmac(
            algo: "sha256",
            data: $password,
            key: self::$pepper
        );
        return password_hash(
            password: $pepperedPassword,
            algo: PASSWORD_ARGON2ID
        );
	}
	
	public static function verify(string $password,
                                  string $hashedPassword): bool
	{
        self::setPepper();
		$pepperedPassword = hash_hmac(
            algo: "sha256",
            data: $password,
            key: self::$pepper
        );
		return password_verify(
            password: $pepperedPassword,
            hash: $hashedPassword
        );
	}
}