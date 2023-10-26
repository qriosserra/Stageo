<?php

namespace Stageo\Model\Repository;

use Exception;
use Stageo\Model\Object\Convention;
use Stageo\Model\Object\CoreObject;

class ConventionRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Convention();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select(["id_convention" => $id])[0] ?? null;
    }

    /**
     * @param int $id
     * @return Convention[]|null
     * @throws Exception
     */
    public function getByEntrepriseId(int $id): ?array
    {
        return $this->select(["id_entreprise" => $id]) ?? null;
    }

    /**
     * @param int $id
     * @return Convention[]|null
     * @throws Exception
     */
    public function getByLoginEtudiant(int $id): ?array
    {
        return $this->select(["login" => $id]) ?? null;
    }
}