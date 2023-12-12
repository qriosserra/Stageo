<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("suivi")]
class Suivi extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?string    $id_suivi = null,
                                private string|NullDataType|null $date_creation = null,
                                private string|NullDataType|null $date_modification = null,
                                private ?bool                    $modifiable = true,
                                private ?bool                    $valide = false,
                                private string|NullDataType|null $raison_refus = null,
                                private ?bool                    $valide_pedagogiquement = false,
                                private ?bool                    $avenants = false,
                                private string|NullDataType|null $details_avenants = null,
                                private string|NullDataType|null $date_retour = null,
                                private string|NullDataType|null $id_convention = null)
    {
    }

    public function getModifiable(): ?bool
    {
        return $this->modifiable;
    }

    public function setModifiable(?bool $modifiable): void
    {
        $this->modifiable = $modifiable;
    }

    /**
     * @return string|null
     */
    public function getIdSuivi(): ?string
    {
        return $this->id_suivi;
    }

    /**
     * @param string|null $id_suivi
     */
    public function setIdSuivi(?string $id_suivi): void
    {
        $this->id_suivi = $id_suivi;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateCreation(): string|NullDataType|null
    {
        return $this->date_creation;
    }

    /**
     * @param NullDataType|string|null $date_creation
     */
    public function setDateCreation(string|NullDataType|null $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateModification(): string|NullDataType|null
    {
        return $this->date_modification;
    }

    /**
     * @param NullDataType|string|null $date_modification
     */
    public function setDateModification(string|NullDataType|null $date_modification): void
    {
        $this->date_modification = $date_modification;
    }

    /**
     * @return bool|null
     */
    public function getValide(): ?bool
    {
        return $this->valide;
    }

    /**
     * @param bool|null $valide
     */
    public function setValide(?bool $valide): void
    {
        $this->valide = $valide;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getRaisonRefus(): string|NullDataType|null
    {
        return $this->raison_refus;
    }

    /**
     * @param NullDataType|string|null $raison_refus
     */
    public function setRaisonRefus(string|NullDataType|null $raison_refus): void
    {
        $this->raison_refus = $raison_refus;
    }

    /**
     * @return bool|null
     */
    public function getValidePedagogiquement(): ?bool
    {
        return $this->valide_pedagogiquement;
    }

    /**
     * @param bool|null $valide_pedagogiquement
     */
    public function setValidePedagogiquement(?bool $valide_pedagogiquement): void
    {
        $this->valide_pedagogiquement = $valide_pedagogiquement;
    }

    /**
     * @return bool|null
     */
    public function getAvenants(): ?bool
    {
        return $this->avenants;
    }

    /**
     * @param bool|null $avenants
     */
    public function setAvenants(?bool $avenants): void
    {
        $this->avenants = $avenants;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDetailsAvenants(): string|NullDataType|null
    {
        return $this->details_avenants;
    }

    /**
     * @param NullDataType|string|null $details_avenants
     */
    public function setDetailsAvenants(string|NullDataType|null $details_avenants): void
    {
        $this->details_avenants = $details_avenants;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateRetour(): string|NullDataType|null
    {
        return $this->date_retour;
    }

    /**
     * @param NullDataType|string|null $date_retour
     */
    public function setDateRetour(string|NullDataType|null $date_retour): void
    {
        $this->date_retour = $date_retour;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdConvention(): string|NullDataType|null
    {
        return $this->id_convention;
    }

    /**
     * @param NullDataType|string|null $id_convention
     */
    public function setIdConvention(string|NullDataType|null $id_convention): void
    {
        $this->id_convention = $id_convention;
    }
}