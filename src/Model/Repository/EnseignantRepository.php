<?php

namespace Stageo\Model\Repository;

use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Enseignant;

class EnseignantRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Enseignant();
    }
}