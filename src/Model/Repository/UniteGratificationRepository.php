<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\UniteGratification;

class UniteGratificationRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new UniteGratification();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_unite_gratification", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}