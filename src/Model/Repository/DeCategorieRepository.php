<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\DeCategorie;
use Stageo\Model\Repository\CoreRepository;

class DeCategorieRepository extends CoreRepository
{

    protected function getObject(): CoreObject
    {
        return new DeCategorie();
    }

    public function getByIdOffre(int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }

    public function getByIdCategorie(int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_categorie", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}