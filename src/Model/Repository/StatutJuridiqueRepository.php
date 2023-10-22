<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\StatutJuridique;

class StatutJuridiqueRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new StatutJuridique();
    }

    public function getStatutJuridiqueById(int|string $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_statut_juridique", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}