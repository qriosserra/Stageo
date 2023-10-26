<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("code_postal")]
class CodePostal extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string $id_code_postal = null)
    {
    }

    /**
     * @return string|null
     */
    public function getIdCodePostal(): ?string
    {
        return $this->id_code_postal;
    }

    /**
     * @param string|null $id_code_postal
     */
    public function setIdCodePostal(?string $id_code_postal): void
    {
        $this->id_code_postal = $id_code_postal;
    }
}