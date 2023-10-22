<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CodePostal;
use Stageo\Model\Object\CoreObject;

class CodePostalRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new CodePostal();
    }

    public function getById(int|string $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_code_postal", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}