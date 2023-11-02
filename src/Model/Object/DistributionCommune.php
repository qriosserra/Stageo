<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;
use Stageo\Model\Object\CoreObject;

#[Table("distribution_commune")]
class DistributionCommune extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int $id_distribution_commune = null,
                                private ?int               $code_postal = null,
                                private ?string            $commune = null,
                                private ?string            $id_pays = null)
    {
    }

    public function getIdDistributionCommune(): ?int
    {
        return $this->id_distribution_commune;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function getIdPays(): ?string
    {
        return $this->id_pays;
    }
}