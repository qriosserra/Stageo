<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("type_structure")]
class TypeStructure extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string $id_type_structure = null,
                                private ?string $libelle = null)
    {
    }

    /**
     * @return string|null
     */
    public function getIdTypeStructure(): ?string
    {
        return $this->id_type_structure;
    }

    /**
     * @param string|null $id_type_structure
     */
    public function setIdTypeStructure(?string $id_type_structure): void
    {
        $this->id_type_structure = $id_type_structure;
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