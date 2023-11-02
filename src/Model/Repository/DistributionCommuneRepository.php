<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Repository\CoreRepository;
use Stageo\Model\Object\DistributionCommune;

class DistributionCommuneRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new DistributionCommune();
    }

    public function getById(mixed $id_distribution_commune): ?CoreObject
    {
        return $this->select(new QueryCondition("id_distribution_commune", ComparisonOperator::EQUAL, $id_distribution_commune))[0] ?? null;
    }
}