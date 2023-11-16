<?php

namespace Stageo\Model\Repository;

use Stageo\Model\Object\Configuration;
use Stageo\Model\Object\CoreObject;

class ConfigurationRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Configuration();
    }

    public function getConfiguration(): ?Configuration
    {
        return $this->select()[0] ?? null;
    }
}