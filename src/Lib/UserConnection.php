<?php

namespace Stageo\Lib;

use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Lib\HTTP\Session;

class UserConnection
{
	private static string $key = __CLASS__;

    public static function signIn(Etudiant|Enseignant|Entreprise $user): void
	{
		Session::set(self::$key, $user);
	}

    public static function isSignedIn(): bool
	{
		return Session::contains(self::$key);
	}

    public static function signOut(): void
	{
		Session::delete(self::$key);
	}

    public static function getSignedInUser(): Etudiant|Entreprise|Enseignant|null
	{
		return Session::get(self::$key) ?? null;
	}

    public static function isUser($idUser) : bool
	{
		return self::getSignedInUser()->getIdUser() === $idUser;
	}
}