<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;


#[Table("offre")]
class Offre extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int       $id_offre = null,
                                private string|null              $description = null,
                                private string|NullDataType|null $thematique = null,
                                private string|NullDataType|null $secteur = null,
                                private string|NullDataType|null $taches = null,
                                private string|NullDataType|null $commentaires = null,
                                private float|NullDataType|null  $gratification = null,
                                private string|null              $type = null,
                                private string|NullDataType|null    $login = null,
                                private string|NullDataType|null $id_unite_gratification = null,
                                private int|null                 $id_entreprise = null,
                                private string|NullDataType|null $date_debut = null,
                                private string|NullDataType|null $date_fin = null,
                                private string|NullDataType|null $niveau = null,
                                private bool|NullDataType|null $valider = null,
    )
    {
    }

    public function getValider(): bool|NullDataType|null
    {
        return $this->valider;
    }

    public function setValider(bool|NullDataType|null $valider): void
    {
        $this->valider = $valider;
    }

    public function getNiveau(): string|NullDataType|null
    {
        return $this->niveau;
    }

    public function setNiveau(string|NullDataType|null $niveau): void
    {
        $this->niveau = $niveau;
    }

    public function getDateDebut(): string|NullDataType|null
    {
        return $this->date_debut;
    }

    public function setDateDebut(string|NullDataType|null $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    public function getDateFin(): string|NullDataType|null
    {
        return $this->date_fin;
    }

    public function setDateFin(string|NullDataType|null $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    public function getType(): string|NullDataType|null
    {
        return $this->type;
    }

    public function setType(string|NullDataType|null $type): void
    {
        $this->type = $type;
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
     * @return NullDataType|float|null
     */
    public function getGratification(): float|NullDataType|null
    {
        return $this->gratification;
    }

    /**
     * @param NullDataType|float|null $gratification
     */
    public function setGratification(float|NullDataType|null $gratification): void
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
     * @return string|NullDataType|null
     */
    public function getLogin(): string|NullDataType|null
    {
        return $this->login;
    }

    /**
     * @param string|NullDataType|null $login
     */
    public function setLogin(string|NullDataType|null $login): void
    {
        $this->login = $login;
    }


}