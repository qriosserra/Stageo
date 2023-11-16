<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Secretaire;

class SecretaireRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Secretaire();
    }

    public function getByEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }
    //
}