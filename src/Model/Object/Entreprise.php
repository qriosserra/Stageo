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
                                private string|NullDataType|null $hashed_password = null,
                                private string|NullDataType|null $raison_sociale = null,
                                private string|NullDataType|null $adresse_voie = null,
                                private string|NullDataType|null $code_naf = null,
                                private string|NullDataType|null $telephone = null,
                                private string|NullDataType|null $siret = null,
                                private string|NullDataType|null $statut_juridique = null,
                                private string|NullDataType|null $type_structure = null,
                                private string|NullDataType|null $effectif = null,
                                private string|NullDataType|null $site = null,
                                private string|NullDataType|null $fax = null,
                                private string|NullDataType|null $id_code_postal = null,
    )
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

    /**
     * @return NullDataType|string|null
     */
    public function getRaisonSociale(): string|NullDataType|null
    {
        return $this->raison_sociale;
    }

    public function getAdresseVoie(): string|NullDataType|null
    {
        return $this->adresse_voie;
    }

    public function setAdresseVoie(string|NullDataType|null $adresse_voie): void
    {
        $this->adresse_voie = $adresse_voie;
    }

    public function getCodeNaf(): string|NullDataType|null
    {
        return $this->code_naf;
    }

    public function setCodeNaf(string|NullDataType|null $code_naf): void
    {
        $this->code_naf = $code_naf;
    }

    public function getTelephone(): string|NullDataType|null
    {
        return $this->telephone;
    }

    public function setTelephone(string|NullDataType|null $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getSiret(): string|NullDataType|null
    {
        return $this->siret;
    }

    public function setSiret(string|NullDataType|null $siret): void
    {
        $this->siret = $siret;
    }

    public function getStatutJuridique(): string|NullDataType|null
    {
        return $this->statut_juridique;
    }

    public function setStatutJuridique(string|NullDataType|null $statut_juridique): void
    {
        $this->statut_juridique = $statut_juridique;
    }

    public function getTypeStructure(): string|NullDataType|null
    {
        return $this->type_structure;
    }

    public function setTypeStructure(string|NullDataType|null $type_structure): void
    {
        $this->type_structure = $type_structure;
    }

    public function getEffectif(): string|NullDataType|null
    {
        return $this->effectif;
    }

    public function setEffectif(string|NullDataType|null $effectif): void
    {
        $this->effectif = $effectif;
    }

    public function getSite(): string|NullDataType|null
    {
        return $this->site;
    }

    public function setSite(string|NullDataType|null $site): void
    {
        $this->site = $site;
    }

    public function getFax(): string|NullDataType|null
    {
        return $this->fax;
    }

    public function setFax(string|NullDataType|null $fax): void
    {
        $this->fax = $fax;
    }

    public function getIdCodePostal(): string|NullDataType|null
    {
        return $this->id_code_postal;
    }

    public function setIdCodePostal(string|NullDataType|null $id_code_postal): void
    {
        $this->id_code_postal = $id_code_postal;
    }

}