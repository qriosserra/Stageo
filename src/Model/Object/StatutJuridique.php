<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("statut_juridique")]
class StatutJuridique extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string $id_statut_juridique = null,
                                private ?string               $libelle = null)
    {
    }

    /**
     * @return string|null
     */
    public function getIdStatutJuridique(): ?string
    {
        return $this->id_statut_juridique;
    }

    /**
     * @param string|null $id_statut_juridique
     */
    public function setIdStatutJuridique(?string $id_statut_juridique): void
    {
        $this->id_statut_juridique = $id_statut_juridique;
    }

    /**
     * @return string|null
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @param string|null $libelle
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }
}