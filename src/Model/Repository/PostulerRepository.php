<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Postuler;

class PostulerRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Postuler();
    }

    public function getById(int $id): ?CoreObject
    {
       return $this->select(new QueryCondition("id_postuler",ComparisonOperator::EQUAL, $id))[0] ?? null;
    }

    public function a_Postuler(string $login,int $id){
        $conditions = [
            new QueryCondition("login", ComparisonOperator::EQUAL, $login),
            new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id)
        ];
        return $this->select($conditions)[0] ?? null;
    }

}