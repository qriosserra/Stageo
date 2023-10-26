<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("taille_entreprise")]
class TailleEntreprise extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string $id_taille_entreprise = null,
                                private ?string               $libelle = null)
    {
    }

    /**
     * @return string|null
     */
    public function getIdTailleEntreprise(): ?string
    {
        return $this->id_taille_entreprise;
    }

    /**
     * @param string|null $id_taille_entreprise
     */
    public function setIdTailleEntreprise(?string $id_taille_entreprise): void
    {
        $this->id_taille_entreprise = $id_taille_entreprise;
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