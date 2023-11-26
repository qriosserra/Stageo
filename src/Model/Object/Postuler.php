<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\CompositePrimaryKey;
use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("postuler")]
class Postuler extends CoreObject
{
    public function __construct(
        #[CompositePrimaryKey('id_offre', 'login')]
        private ?int $id_offre = null,
        private ?string $login = null,
        private ?string $cv = null,
        private ?string $lettre_motivation = null,
        private ?string $complement = null
    ) {
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