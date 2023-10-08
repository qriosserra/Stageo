<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\Table;

#[Table("enseignant")]
class Enseignant extends CoreObject
{
    public function __construct(private ?int                     $id_enseignant = null,
                                private string|NullDataType|null $email = null,
                                private string|NullDataType|null $unverified_email = null,
                                private string|NullDataType|null $nonce = null,
                                private int|NullDataType|null    $nonce_timestamp = null,
                                private string|NullDataType|null $hashed_password = null,
                                private string|NullDataType|null $nom = null,
                                private string|NullDataType|null $prenom = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdEnseignant(): ?int
    {
        return $this->id_enseignant;
    }

    /**
     * @param int|null $id_enseignant
     */
    public function setIdEnseignant(?int $id_enseignant): void
    {
        $this->id_enseignant = $id_enseignant;
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