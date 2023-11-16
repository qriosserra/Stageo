<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\Table;

#[Table("secretaire")]
class Secretaire extends User
{
    public function __construct(private ?int                     $id_secretaire = null,
                                private string|NullDataType|null $email = null,
                                private string|NullDataType|null $hashed_password = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdSecretaire(): ?int
    {
        return $this->id_secretaire;
    }

    /**
     * @param int|null $id_secretaire
     */
    public function setIdsecretaire(?int $id_secretaire): void
    {
        $this->id_secretaire = $id_secretaire;
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
    //
}