<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\Table;

#[Table("offre_categorie")]
class DeCategorie extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int $id_categorie = null,
                                #[PrimaryKey] private ?int       $id_offre  = null)
    {}

    public function getIdCategorie(): ?int
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?int $id_categorie): void
    {
        $this->id_categorie = $id_categorie;
    }

    public function getIdOffre(): ?int
    {
        return $this->id_offre;
    }

    public function setIdOffre(?int $id_offre): void
    {
        $this->id_offre = $id_offre;
    }


}