<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;


#[Table("offre")]
class Offre extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int       $id_offre = null,
                                private int|null                 $id_entreprise = null,
                                private string|null              $description = null,
                                private string|NullDataType|null $secteur = null,
                                private string|NullDataType|null $thematique = null,
                                private string|NullDataType|null $taches = null,
                                private string|NullDataType|null $commentaires = null,
                                private float|NullDataType|null  $gratification = null,
                                private string|NullDataType|null $id_unite_gratification = null,
                                private int|NullDataType|null    $id_etudiant = null)
    {
    }

    /**
     * @return int|null
     */
    public function getIdOffre(): ?int
    {
        return $this->id_offre;
    }

    /**
     * @param int|null $id_offre
     */
    public function setIdOffre(?int $id_offre): void
    {
        $this->id_offre = $id_offre;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getIdEntreprise(): ?int
    {
        return $this->id_entreprise;
    }

    /**
     * @param int|null $id_entreprise
     */
    public function setIdEntreprise(?int $id_entreprise): void
    {
        $this->id_entreprise = $id_entreprise;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getSecteur(): string|NullDataType|null
    {
        return $this->secteur;
    }

    /**
     * @param NullDataType|string|null $secteur
     */
    public function setSecteur(string|NullDataType|null $secteur): void
    {
        $this->secteur = $secteur;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getThematique(): string|NullDataType|null
    {
        return $this->thematique;
    }

    /**
     * @param NullDataType|string|null $thematique
     */
    public function setThematique(string|NullDataType|null $thematique): void
    {
        $this->thematique = $thematique;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getTaches(): string|NullDataType|null
    {
        return $this->taches;
    }

    /**
     * @param NullDataType|string|null $taches
     */
    public function setTaches(string|NullDataType|null $taches): void
    {
        $this->taches = $taches;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getCommentaires(): string|NullDataType|null
    {
        return $this->commentaires;
    }

    /**
     * @param NullDataType|string|null $commentaires
     */
    public function setCommentaires(string|NullDataType|null $commentaires): void
    {
        $this->commentaires = $commentaires;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getGratification(): string|NullDataType|null
    {
        return $this->gratification;
    }

    /**
     * @param NullDataType|string|null $gratification
     */
    public function setGratification(string|NullDataType|null $gratification): void
    {
        $this->gratification = $gratification;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdUniteGratification(): string|NullDataType|null
    {
        return $this->id_unite_gratification;
    }

    /**
     * @param NullDataType|string|null $id_unite_gratification
     */
    public function setIdUniteGratification(string|NullDataType|null $id_unite_gratification): void
    {
        $this->id_unite_gratification = $id_unite_gratification;
    }

    /**
     * @return int|NullDataType|null
     */
    public function getIdEtudiant(): int|NullDataType|null
    {
        return $this->id_etudiant;
    }

    /**
     * @param int|NullDataType|null $id_etudiant
     */
    public function setIdEtudiant(int|NullDataType|null $id_etudiant): void
    {
        $this->id_etudiant = $id_etudiant;
    }


}