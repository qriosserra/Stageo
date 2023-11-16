<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Categorie;

class CategorieRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Categorie();
    }
    public function getByLibelle(String $libelle): ?Categorie{
        $res =  $this->select(new QueryCondition("libelle", ComparisonOperator::LIKE, "%" . $libelle . "%"));
        if (isset($res[0]) && $res[0] != NUll){
            return $res[0];
        }else{
            return Null;
        }
    }
}