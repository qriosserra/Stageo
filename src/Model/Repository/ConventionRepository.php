<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\LogicalOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\CoreObject;

class ConventionRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Convention();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_convention", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }

    /**
     * @param int $id
     * @return Convention[]|null
     * @throws Exception
     */
    public function getByEntrepriseId(int $id): ?array
    {
        return $this->select(new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $id));
    }

    /**
     * @param int $id
     * @return Convention[]|null
     * @throws Exception
     */
    public function getByLogin(string $login): ?Convention
    {
        return $this->select(new QueryCondition("login", ComparisonOperator::EQUAL, $login))[0] ?? null;
    }

    public function getWhereLoginEnseignantIsNull(int $limit = 999): array
    {
        $pdo = DatabaseConnection::getPdo()->prepare(<<<SQL
            SELECT *
            FROM stg_convention
            WHERE verification_admin IS TRUE
            AND verification_secretaire IS TRUE
            AND login_enseignant IS NULL
            LIMIT $limit;
        SQL
        );
        $pdo->execute();

        for ($objectArray = $pdo->fetch();
             $objectArray != false;
             $objectArray = $pdo->fetch()) {
            $objects[] = $this->getObject()->construct($objectArray);
        }
        return $objects ?? [];
    }
}