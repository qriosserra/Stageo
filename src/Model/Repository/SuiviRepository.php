<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Suivi;

class SuiviRepository extends CoreRepository
{

    protected function getObject(): CoreObject
    {
        return new Suivi();
    }

    public function getValide(): ?CoreObject
    {
        return $this->select(new QueryCondition("valide", ComparisonOperator::EQUAL, true))[0] ?? null;
    }

    public function getModifiable(): ?CoreObject
    {
        return $this->select(new QueryCondition("modifiable", ComparisonOperator::EQUAL, true))[0] ?? null;
    }

    public function getByIdConvention(?int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}