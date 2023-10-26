<?php

namespace Stageo\Model\Repository;

use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Suivi;

class SuiviRepository extends CoreRepository
{

    protected function getObject(): CoreObject
    {
        return new Suivi();
    }
}