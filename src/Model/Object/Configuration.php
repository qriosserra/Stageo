<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("configuration")]
class Configuration extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int $id_configuration = null,
                                private ?float             $gratification_minimale = null,
                                private ?string            $annee_scolaire = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdConfiguration(): ?int
    {
        return $this->id_configuration;
    }

    /**
     * @param int|null $id_configuration
     */
    public function setIdConfiguration(?int $id_configuration): void
    {
        $this->id_configuration = $id_configuration;
    }

    /**
     * @return float|null
     */
    public function getGratificationMinimale(): ?float
    {
        return $this->gratification_minimale;
    }

    /**
     * @param float|null $gratification_minimale
     */
    public function setGratificationMinimale(?float $gratification_minimale): void
    {
        $this->gratification_minimale = $gratification_minimale;
    }

    /**
     * @return string|null
     */
    public function getAnneeScolaire(): ?string
    {
        return $this->annee_scolaire;
    }

    /**
     * @param string|null $annee_scolaire
     */
    public function setAnneeScolaire(?string $annee_scolaire): void
    {
        $this->annee_scolaire = $annee_scolaire;
    }
}