<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Enseignant;

class EnseignantRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Enseignant();
    }

    /**
     * @throws Exception
     */
    public function getByLogin(?string $login): ?CoreObject
    {
        return $this->select([new QueryCondition("login", ComparisonOperator::EQUAL, $login)])[0] ?? null;
    }
}