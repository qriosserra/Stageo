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

    /**
     * @throws Exception
     */
    public function getAllEmails(): array
    {
        $query = "SELECT email from stg_enseignant";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $listeEmail = $stmt->fetchAll();

        return $listeEmail;



    }

}