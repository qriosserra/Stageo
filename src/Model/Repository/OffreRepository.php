<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Offre;

class OffreRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Offre();
    }

}