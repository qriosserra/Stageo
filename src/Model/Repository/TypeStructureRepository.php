<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\TypeStructure;

class TypeStructureRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new TypeStructure();
    }

    public function getTypeStructureById(int|string $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_type_structure", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}