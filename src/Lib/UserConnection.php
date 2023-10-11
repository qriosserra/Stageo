<?php

namespace Stageo\Lib;

use Stageo\Lib\HTTP\Session;
use Stageo\Model\Object\Enseignant;
use Stageo\Model\Object\Entreprise;
use Stageo\Model\Object\Etudiant;
use Stageo\Model\Object\User;

class UserConnection
{
	private static string $key = __CLASS__;

    public static function signIn(User $user): void
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

    public static function getSignedInUser(): ?User
	{
		return Session::get(self::$key) ?? null;
	}

    public static function isUser(int $idUser, object $instance) : bool
	{
        $user = self::getSignedInUser();
		if ($instance instanceof Etudiant and $user instanceof Etudiant)
            return $user->getIdEtudiant() === $idUser;
        elseif ($instance instanceof Entreprise and $user instanceof Entreprise)
            return $user->getIdEntreprise() === $idUser;
        elseif ($instance instanceof Enseignant and $user instanceof Enseignant)
            return $user->getIdEnseignant() === $idUser;
        return false;
	}

    public static function isInstance(object $instance): bool
    {
        return self::getSignedInUser() instanceof $instance;
    }
}