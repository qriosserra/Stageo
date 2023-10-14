<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Entreprise;

class EntrepriseRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Entreprise();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select([new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $id)])[0] ?? null;
    }

    public function getByEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }

    public function getByUnverifiedEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("unverified_email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }

}