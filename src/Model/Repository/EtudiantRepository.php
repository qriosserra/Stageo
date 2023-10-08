<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Etudiant;

class EtudiantRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Etudiant();
    }

    /**
     * @throws Exception
     */
    public function getById(int $id): ?CoreObject
    {
        return $this->select([new QueryCondition("id_etudiant", ComparisonOperator::EQUAL, $id)])[0] ?? null;
    }

    public function getByLogin(string $login): ?CoreObject
    {
        return $this->select([new QueryCondition("login", ComparisonOperator::EQUAL, $login)])[0] ?? null;
    }

    /**
     * @throws Exception
     */
    public function getByEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }

    /**
     * @throws Exception
     */
    public function getByUnverifiedEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("unverified_email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }
}