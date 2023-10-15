<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("etudiant")]
class Etudiant extends User
{
    public function __construct(#[PrimaryKey] private ?int       $id_etudiant = null,
                                private string|null              $login = null,
                                private string|NullDataType|null $email = null,
                                private string|NullDataType|null $unverified_email = null,
                                private string|NullDataType|null $nonce = null,
                                private int|NullDataType|null    $nonce_timestamp = null,
                                private string|NullDataType|null $hashed_password = null,
                                private string|NullDataType|null $nom = null,
                                private string|NullDataType|null $prenom = null,
                                private string|NullDataType|null $telephone = null,
                                private string|NullDataType|null $telephone_fixe = null,
                                private string|NullDataType|null $adresse_voie = null,
                                private string|NullDataType|null $email_etudiant = null,
                                private string|NullDataType|null $civilite = null,
                                private string|NullDataType|null $id_commune = null,
                                private string|NullDataType|null $id_departement = null,
                                private string|NullDataType|null $id_etape = null,
                                private string|NullDataType|null $id_ufr = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdEtudiant(): ?int
    {
        return $this->id_etudiant;
    }

    /**
     * @param int|null $id_etudiant
     */
    public function setIdEtudiant(?int $id_etudiant): void
    {
        $this->id_etudiant = $id_etudiant;
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

    /**
     * @return NullDataType|string|null
     */
    public function getTelephone(): string|NullDataType|null
    {
        return $this->telephone;
    }

    /**
     * @param NullDataType|string|null $telephone
     */
    public function setTelephone(string|NullDataType|null $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getTelephoneFixe(): string|NullDataType|null
    {
        return $this->telephone_fixe;
    }

    /**
     * @param NullDataType|string|null $telephone_fixe
     */
    public function setTelephoneFixe(string|NullDataType|null $telephone_fixe): void
    {
        $this->telephone_fixe = $telephone_fixe;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getAdresseVoie(): string|NullDataType|null
    {
        return $this->adresse_voie;
    }

    /**
     * @param NullDataType|string|null $adresse_voie
     */
    public function setAdresseVoie(string|NullDataType|null $adresse_voie): void
    {
        $this->adresse_voie = $adresse_voie;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getEmailEtudiant(): string|NullDataType|null
    {
        return $this->email_etudiant;
    }

    /**
     * @param NullDataType|string|null $email_etudiant
     */
    public function setEmailEtudiant(string|NullDataType|null $email_etudiant): void
    {
        $this->email_etudiant = $email_etudiant;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getCivilite(): string|NullDataType|null
    {
        return $this->civilite;
    }

    /**
     * @param NullDataType|string|null $civilite
     */
    public function setCivilite(string|NullDataType|null $civilite): void
    {
        $this->civilite = $civilite;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdCommune(): string|NullDataType|null
    {
        return $this->id_commune;
    }

    /**
     * @param NullDataType|string|null $id_commune
     */
    public function setIdCommune(string|NullDataType|null $id_commune): void
    {
        $this->id_commune = $id_commune;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdDepartement(): string|NullDataType|null
    {
        return $this->id_departement;
    }

    /**
     * @param NullDataType|string|null $id_departement
     */
    public function setIdDepartement(string|NullDataType|null $id_departement): void
    {
        $this->id_departement = $id_departement;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdEtape(): string|NullDataType|null
    {
        return $this->id_etape;
    }

    /**
     * @param NullDataType|string|null $id_etape
     */
    public function setIdEtape(string|NullDataType|null $id_etape): void
    {
        $this->id_etape = $id_etape;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdUfr(): string|NullDataType|null
    {
        return $this->id_ufr;
    }

    /**
     * @param NullDataType|string|null $id_ufr
     */
    public function setIdUfr(string|NullDataType|null $id_ufr): void
    {
        $this->id_ufr = $id_ufr;
    }
}