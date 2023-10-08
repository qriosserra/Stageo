<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("entreprise")]
class Entreprise extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int       $id_entreprise = null,
                                private string|NullDataType|null $email = null,
                                private string|NullDataType|null $unverified_email = null,
                                private string|NullDataType|null $nonce = null,
                                private int|NullDataType|null    $nonce_timestamp = null,
                                private string|NullDataType|null $hashed_password = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdEntreprise(): ?int
    {
        return $this->id_entreprise;
    }

    /**
     * @param int|null $id_entreprise
     */
    public function setIdEntreprise(?int $id_entreprise): void
    {
        $this->id_entreprise = $id_entreprise;
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
    public function getUnverifiedEmail(): string|NullDataType|null
    {
        return $this->unverified_email;
    }

    /**
     * @param NullDataType|string|null $unverified_email
     */
    public function setUnverifiedEmail(string|NullDataType|null $unverified_email): void
    {
        $this->unverified_email = $unverified_email;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getNonce(): string|NullDataType|null
    {
        return $this->nonce;
    }

    /**
     * @param NullDataType|string|null $nonce
     */
    public function setNonce(string|NullDataType|null $nonce): void
    {
        $this->nonce = $nonce;
    }

    /**
     * @return int|NullDataType|null
     */
    public function getNonceTimestamp(): int|NullDataType|null
    {
        return $this->nonce_timestamp;
    }

    /**
     * @param int|NullDataType|null $nonce_timestamp
     */
    public function setNonceTimestamp(int|NullDataType|null $nonce_timestamp): void
    {
        $this->nonce_timestamp = $nonce_timestamp;
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
}