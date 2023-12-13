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

    public function getnbcandatures(string $login): ?int
    {
        try {
            $query = "SELECT COUNT(*)
                  FROM stg_postuler
                  WHERE login = :login"; // Use a named parameter for login
            $pdo = DatabaseConnection::getPdo()->prepare($query);
            $values["login"]= $login;
            $pdo->execute($values);

            $result = $pdo->fetchColumn(); // Use fetchColumn to directly retrieve the count

            return $result !== false ? (int)$result : null;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }
}