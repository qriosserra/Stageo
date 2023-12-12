<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\Table;

#[Table("enseignant")]
class Enseignant extends User
{
    public function __construct(private ?string                     $login = null,
                                private string|NullDataType|null $email = null,
                                private string|NullDataType|null $nom = null,
                                private string|NullDataType|null $prenom = null,
                                private bool|NullDataType|null $estAdmin = null)
    {
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string|null $login
     */
    public function setLogin(?string $login): void
    {
        $this->login = $login;
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

    /**
     * @return bool|NullDataType|null
     */
    public function getEstAdmin(): bool|NullDataType|null
    {
        return $this->estAdmin;
    }

    /**
     * @param bool|NullDataType|null $estAdmin
     */
    public function setEstAdmin(bool|NullDataType|null $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }


}