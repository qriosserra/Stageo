<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("postuler")]
class Postuler extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int       $id_postuler = null,
                                private string|null              $cv = null,
                                private string|null              $login=null,
                                private int|null                 $id_offre=null,
                                private string|NullDataType|null $lettre_motivation = null,
                                private string|NullDataType|null $complement = null)
    {
    }

    public function getIdPostuler(): ?int
    {
        return $this->id_postuler;
    }

    public function setIdPostuler(?int $id_postuler): void
    {
        $this->id_postuler = $id_postuler;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): void
    {
        $this->cv = $cv;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): void
    {
        $this->login = $login;
    }

    public function getIdOffre(): ?int
    {
        return $this->id_offre;
    }

    public function setIdOffre(?int $id_offre): void
    {
        $this->id_offre = $id_offre;
    }

    public function getLettreMotivation(): string|NullDataType|null
    {
        return $this->lettre_motivation;
    }

    public function setLettreMotivation(string|NullDataType|null $lettre_motivation): void
    {
        $this->lettre_motivation = $lettre_motivation;
    }

    public function getComplement(): string|NullDataType|null
    {
        return $this->complement;
    }

    public function setComplement(string|NullDataType|null $complement): void
    {
        $this->complement = $complement;
    }






}