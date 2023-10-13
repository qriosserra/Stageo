<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;


#[Table("offre")]
class Offre extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int $id_offre = null,
                                private int|null $id_entreprise = null,
                                private string|null $description  = null,
                                private string|NullDataType|null $secteur = null,
                                private string|NullDataType|null $thematique = null,
                                private string|NullDataType|null $tache = null,
                                private string|NullDataType|null $commentaire = null,
                                private string|NullDataType|null $gratification = null,
                                private string|NullDataType|null $unite_gratification = null,
                                private int|NullDataType|null $id_etudiant = null)
    {}

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
    public function getTache(): string|NullDataType|null
    {
        return $this->tache;
    }

    /**
     * @param NullDataType|string|null $tache
     */
    public function setTache(string|NullDataType|null $tache): void
    {
        $this->tache = $tache;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getCommentaire(): string|NullDataType|null
    {
        return $this->commentaire;
    }

    /**
     * @param NullDataType|string|null $commentaire
     */
    public function setCommentaire(string|NullDataType|null $commentaire): void
    {
        $this->commentaire = $commentaire;
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
    public function getUniteGratification(): string|NullDataType|null
    {
        return $this->unite_gratification;
    }

    /**
     * @param NullDataType|string|null $unite_gratification
     */
    public function setUniteGratification(string|NullDataType|null $unite_gratification): void
    {
        $this->unite_gratification = $unite_gratification;
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