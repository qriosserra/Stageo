<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("etudiant")]
class Etudiant extends User
{
    public function __construct(#[PrimaryKey] private ?string       $login = null,
                                private string|NullDataType|null $nom = null,
                                private string|NullDataType|null $prenom = null,
                                private string|NullDataType|null $telephone = null,
                                private string|NullDataType|null $telephone_fixe = null,
                                private string|NullDataType|null $email_etudiant = null,
                                private string|NullDataType|null $annee = null,
                                private string|NullDataType|null $civilite = null,
                                private string|NullDataType|null $numero_voie = null,
                                private string|NullDataType|null $id_commune = null,
                                private string|NullDataType|null $id_departement = null,
                                private string|NullDataType|null $id_etape = null,
                                private string|NullDataType|null $id_ufr = null)
    {
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): void
    {
        $this->login = $login;
    }

    public function getNom(): string|NullDataType|null
    {
        return $this->nom;
    }

    public function setNom(string|NullDataType|null $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string|NullDataType|null
    {
        return $this->prenom;
    }

    public function setPrenom(string|NullDataType|null $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getTelephone(): string|NullDataType|null
    {
        return $this->telephone;
    }

    public function setTelephone(string|NullDataType|null $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getTelephoneFixe(): string|NullDataType|null
    {
        return $this->telephone_fixe;
    }

    public function setTelephoneFixe(string|NullDataType|null $telephone_fixe): void
    {
        $this->telephone_fixe = $telephone_fixe;
    }

    public function getEmailEtudiant(): string|NullDataType|null
    {
        return $this->email_etudiant;
    }

    public function setEmailEtudiant(string|NullDataType|null $email_etudiant): void
    {
        $this->email_etudiant = $email_etudiant;
    }

    public function getAnnee(): string|NullDataType|null
    {
        return $this->annee;
    }

    public function setAnnee(string|NullDataType|null $annee): void
    {
        $this->annee = $annee;
    }

    public function getCivilite(): string|NullDataType|null
    {
        return $this->civilite;
    }

    public function setCivilite(string|NullDataType|null $civilite): void
    {
        $this->civilite = $civilite;
    }

    public function getNumeroVoie(): string|NullDataType|null
    {
        return $this->numero_voie;
    }

    public function setNumeroVoie(string|NullDataType|null $numero_voie): void
    {
        $this->numero_voie = $numero_voie;
    }

    public function getIdCommune(): string|NullDataType|null
    {
        return $this->id_commune;
    }

    public function setIdCommune(string|NullDataType|null $id_commune): void
    {
        $this->id_commune = $id_commune;
    }

    public function getIdDepartement(): string|NullDataType|null
    {
        return $this->id_departement;
    }

    public function setIdDepartement(string|NullDataType|null $id_departement): void
    {
        $this->id_departement = $id_departement;
    }

    public function getIdEtape(): string|NullDataType|null
    {
        return $this->id_etape;
    }

    public function setIdEtape(string|NullDataType|null $id_etape): void
    {
        $this->id_etape = $id_etape;
    }

    public function getIdUfr(): string|NullDataType|null
    {
        return $this->id_ufr;
    }

    public function setIdUfr(string|NullDataType|null $id_ufr): void
    {
        $this->id_ufr = $id_ufr;
    }
}