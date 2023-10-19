<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("commune")]
class Commune extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string $id_commune = null,
                                private ?string               $commune = null)
    {
    }

    public function getIdCommune(): string
    {
        return $this->id_commune;
    }

    public function getCommune(): string
    {
        return $this->commune;
    }
}