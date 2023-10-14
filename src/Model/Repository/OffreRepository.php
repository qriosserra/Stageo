<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Offre;

class OffreRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Offre();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select([new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id)])[0] ?? null;
    }

}