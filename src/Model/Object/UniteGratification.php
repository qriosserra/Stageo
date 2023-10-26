<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("unite_gratification")]
class UniteGratification extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string $id_unite_gratification = null,
                                private ?string $libelle = null)
    {
    }

    /**
     * @return string|null
     */
    public function getIdUniteGratification(): ?string
    {
        return $this->id_unite_gratification;
    }

    /**
     * @param string|null $id_unite_gratification
     */
    public function setIdUniteGratification(?string $id_unite_gratification): void
    {
        $this->id_unite_gratification = $id_unite_gratification;
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param string|null $libelle
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }
}