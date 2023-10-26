<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\NullDataType;
use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;

#[Table("convention")]
class Convention extends CoreObject
{
    public function __construct(#[PrimaryKey] private ?int       $id_convention = null,
                                private ?string                  $login = null,
                                private string|NullDataType|null $type_convention = null,
                                private string|NullDataType|null $origine_stage = null,
                                private string|NullDataType|null $annee_universitaire = null,
                                private string|NullDataType|null $thematique = null,
                                private string|NullDataType|null $sujet = null,
                                private string|NullDataType|null $taches = null,
                                private string|NullDataType|null $commentaires = null,
                                private string|NullDataType|null $details = null,
                                private string|NullDataType|null $date_debut = null,
                                private string|NullDataType|null $date_fin = null,
                                private string|NullDataType|null $interruption = null,
                                private string|NullDataType|null $date_interruption_debut = null,
                                private string|NullDataType|null $date_interruption_fin = null,
                                private string|NullDataType|null $heures_total = null,
                                private string|NullDataType|null $jours_hebdomadaire = null,
                                private string|NullDataType|null $heures_hebdomadaire = null,
                                private string|NullDataType|null $commentaires_duree = null,
                                private string|NullDataType|null $gratification = null,
                                private string|NullDataType|null $id_unite_gratification = null,
                                private string|NullDataType|null $avantages_nature = null,
                                private string|NullDataType|null $code_elp = null,
                                private string|NullDataType|null $numero_voie = null,
                                private string|NullDataType|null $id_code_postal = null,
                                private string|NullDataType|null $id_commune = null,
                                private string|NullDataType|null $id_entreprise = null,
                                private string|NullDataType|null $id_tuteur = null,
                                private string|NullDataType|null $id_enseignant = null)
    {
    }

    /**
     * @return NullDataType|string|null
     */
    public function getNumeroVoie(): string|NullDataType|null
    {
        return $this->numero_voie;
    }

    /**
     * @param NullDataType|string|null $numero_voie
     */
    public function setNumeroVoie(string|NullDataType|null $numero_voie): void
    {
        $this->numero_voie = $numero_voie;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdCodePostal(): string|NullDataType|null
    {
        return $this->id_code_postal;
    }

    /**
     * @param NullDataType|string|null $id_code_postal
     */
    public function setIdCodePostal(string|NullDataType|null $id_code_postal): void
    {
        $this->id_code_postal = $id_code_postal;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdCommune(): string|NullDataType|null
    {
        return $this->id_commune;
    }

    /**
     * @param NullDataType|string|null $id_commune
     */
    public function setIdCommune(string|NullDataType|null $id_commune): void
    {
        $this->id_commune = $id_commune;
    }

    /**
     * @return int|null
     */
    public function getIdConvention(): ?int
    {
        return $this->id_convention;
    }

    /**
     * @param int|null $id_convention
     */
    public function setIdConvention(?int $id_convention): void
    {
        $this->id_convention = $id_convention;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string|null $login
     */
    public function setLogin(?string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getTypeConvention(): string|NullDataType|null
    {
        return $this->type_convention;
    }

    /**
     * @param NullDataType|string|null $type_convention
     */
    public function setTypeConvention(string|NullDataType|null $type_convention): void
    {
        $this->type_convention = $type_convention;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getOrigineStage(): string|NullDataType|null
    {
        return $this->origine_stage;
    }

    /**
     * @param NullDataType|string|null $origine_stage
     */
    public function setOrigineStage(string|NullDataType|null $origine_stage): void
    {
        $this->origine_stage = $origine_stage;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getAnneeUniversitaire(): string|NullDataType|null
    {
        return $this->annee_universitaire;
    }

    /**
     * @param NullDataType|string|null $annee_universitaire
     */
    public function setAnneeUniversitaire(string|NullDataType|null $annee_universitaire): void
    {
        $this->annee_universitaire = $annee_universitaire;
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
    public function getSujet(): string|NullDataType|null
    {
        return $this->sujet;
    }

    /**
     * @param NullDataType|string|null $sujet
     */
    public function setSujet(string|NullDataType|null $sujet): void
    {
        $this->sujet = $sujet;
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
    public function getDetails(): string|NullDataType|null
    {
        return $this->details;
    }

    /**
     * @param NullDataType|string|null $details
     */
    public function setDetails(string|NullDataType|null $details): void
    {
        $this->details = $details;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateDebut(): string|NullDataType|null
    {
        return $this->date_debut;
    }

    /**
     * @param NullDataType|string|null $date_debut
     */
    public function setDateDebut(string|NullDataType|null $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateFin(): string|NullDataType|null
    {
        return $this->date_fin;
    }

    /**
     * @param NullDataType|string|null $date_fin
     */
    public function setDateFin(string|NullDataType|null $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getInterruption(): string|NullDataType|null
    {
        return $this->interruption;
    }

    /**
     * @param NullDataType|string|null $interruption
     */
    public function setInterruption(string|NullDataType|null $interruption): void
    {
        $this->interruption = $interruption;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateInterruptionDebut(): string|NullDataType|null
    {
        return $this->date_interruption_debut;
    }

    /**
     * @param NullDataType|string|null $date_interruption_debut
     */
    public function setDateInterruptionDebut(string|NullDataType|null $date_interruption_debut): void
    {
        $this->date_interruption_debut = $date_interruption_debut;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getDateInterruptionFin(): string|NullDataType|null
    {
        return $this->date_interruption_fin;
    }

    /**
     * @param NullDataType|string|null $date_interruption_fin
     */
    public function setDateInterruptionFin(string|NullDataType|null $date_interruption_fin): void
    {
        $this->date_interruption_fin = $date_interruption_fin;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getHeuresTotal(): string|NullDataType|null
    {
        return $this->heures_total;
    }

    /**
     * @param NullDataType|string|null $heures_total
     */
    public function setHeuresTotal(string|NullDataType|null $heures_total): void
    {
        $this->heures_total = $heures_total;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getJoursHebdomadaire(): string|NullDataType|null
    {
        return $this->jours_hebdomadaire;
    }

    /**
     * @param NullDataType|string|null $jours_hebdomadaire
     */
    public function setJoursHebdomadaire(string|NullDataType|null $jours_hebdomadaire): void
    {
        $this->jours_hebdomadaire = $jours_hebdomadaire;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getHeuresHebdomadaire(): string|NullDataType|null
    {
        return $this->heures_hebdomadaire;
    }

    /**
     * @param NullDataType|string|null $heures_hebdomadaire
     */
    public function setHeuresHebdomadaire(string|NullDataType|null $heures_hebdomadaire): void
    {
        $this->heures_hebdomadaire = $heures_hebdomadaire;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getCommentairesDuree(): string|NullDataType|null
    {
        return $this->commentaires_duree;
    }

    /**
     * @param NullDataType|string|null $commentaires_duree
     */
    public function setCommentairesDuree(string|NullDataType|null $commentaires_duree): void
    {
        $this->commentaires_duree = $commentaires_duree;
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
     * @return NullDataType|string|null
     */
    public function getAvantagesNature(): string|NullDataType|null
    {
        return $this->avantages_nature;
    }

    /**
     * @param NullDataType|string|null $avantages_nature
     */
    public function setAvantagesNature(string|NullDataType|null $avantages_nature): void
    {
        $this->avantages_nature = $avantages_nature;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getCodeElp(): string|NullDataType|null
    {
        return $this->code_elp;
    }

    /**
     * @param NullDataType|string|null $code_elp
     */
    public function setCodeElp(string|NullDataType|null $code_elp): void
    {
        $this->code_elp = $code_elp;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdEntreprise(): string|NullDataType|null
    {
        return $this->id_entreprise;
    }

    /**
     * @param NullDataType|string|null $id_entreprise
     */
    public function setIdEntreprise(string|NullDataType|null $id_entreprise): void
    {
        $this->id_entreprise = $id_entreprise;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdTuteur(): string|NullDataType|null
    {
        return $this->id_tuteur;
    }

    /**
     * @param NullDataType|string|null $id_tuteur
     */
    public function setIdTuteur(string|NullDataType|null $id_tuteur): void
    {
        $this->id_tuteur = $id_tuteur;
    }

    /**
     * @return NullDataType|string|null
     */
    public function getIdEnseignant(): string|NullDataType|null
    {
        return $this->id_enseignant;
    }

    /**
     * @param NullDataType|string|null $id_enseignant
     */
    public function setIdEnseignant(string|NullDataType|null $id_enseignant): void
    {
        $this->id_enseignant = $id_enseignant;
    }


}