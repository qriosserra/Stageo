<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("admin")]
class Admin extends User
{
    public function __construct(#[PrimaryKey] private ?int       $id_admin = null,
                                private string|NullDataType|null $email = null,
                                private string|NullDataType|null $nom = null,
                                private string|NullDataType|null $prenom = null,
                                private string|NullDataType|null $hashed_password = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdAdmin(): ?int
    {
        return $this->id_admin;
    }

    /**
     * @param int|null $id_admin
     */
    public function setId_Admin(?int $id_admin): void
    {
        $this->id_admin = $id_admin;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getEmail(): string|NullDataType|null
    {
        return $this->email;
    }

    /**
     * @param NullDataType|string|null $email
     */
    public function setEmail(string|NullDataType|null $email): void
    {
        $this->email = $email;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getHashedPassword(): string|NullDataType|null
    {
        return $this->hashed_password;
    }

    /**
     * @param NullDataType|string|null $hashed_password
     */
    public function setHashedPassword(string|NullDataType|null $hashed_password): void
    {
        $this->hashed_password = $hashed_password;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getNom(): string|NullDataType|null
    {
        return $this->nom;
    }

    /**
     * @param NullDataType|string|null $nom
     */
    public function setNom(string|NullDataType|null $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getPrenom(): string|NullDataType|null
    {
        return $this->prenom;
    }

    /**
     * @param NullDataType|string|null $prenom
     */
    public function setPrenom(string|NullDataType|null $prenom): void
    {
        $this->prenom = $prenom;
    }
}