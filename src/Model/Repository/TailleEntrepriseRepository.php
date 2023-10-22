<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\TailleEntreprise;

class TailleEntrepriseRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new TailleEntreprise();
    }

    public function getTailleEntrepriseById(int|string $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_taille_entreprise", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
}