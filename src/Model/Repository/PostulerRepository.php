<?php

namespace Stageo\Model\Repository;

use Exception;
use PDO;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\LogicalOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Postuler;

class PostulerRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Postuler();
    }

    /**
     * @throws Exception
     */
    public function getById(int $id): ?CoreObject
    {
       return $this->select(new QueryCondition("id_postuler",ComparisonOperator::EQUAL, $id))[0] ?? null;
    }

    /**
     * @throws Exception
     */
    public function a_Postuler(string $login, int $id){
        $conditions = [
            new QueryCondition("login", ComparisonOperator::EQUAL, $login,LogicalOperator::AND),
            new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id)
        ];
        return $this->select($conditions)[0] ?? null;
    }

    public function getNombreEtudiantPostuler(): array {
        $query = "SELECT count(distinct login) FROM stg_postuler;";
        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result[0];
    }

}