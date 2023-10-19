<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Commune;

class CommuneRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Commune();
    }

    public function getByName(string $name, int $limit = 5): ?array
    {
        return $this->select(new QueryCondition("commune", ComparisonOperator::LIKE, $name), $limit) ?? null;
    }
}