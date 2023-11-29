<?php

namespace Stageo\Model\Object;

use Stageo\Lib\Database\PrimaryKey;
use Stageo\Lib\Database\Table;
use Stageo\Model\Object\CoreObject;
#[Table("table_temporaire")]
class tableTemporaire extends CoreObject
{
    public function __construct(
        #[PrimaryKey] private ?int $id_table = null,
        private ?int $Numero_Convention = null,
        private ?string $Numero_etudiant = null,
        private ?string $Nom_etudiant = null,
        private ?string $Prenom_etudiant = null,
        private ?string $Telephone_Perso_etudiant = null,
        private ?string $Telephone_Portable_etudiant = null,
        private ?string $Mail_Perso_etudiant = null,
        private ?string $Mail_Universitaire_etudiant = null,
        private ?string $Code_Ufr = null,
        private ?string $Libelle_UFR = null,
        private ?string $Code_departement = null,
        private ?string $Code_etape = null,
        private ?string $Libelle_Etape = null,
        private ?string $Date_Debut_Stage = null,
        private ?string $Date_Fin_Stage = null,
        private ?string $Interruption = null,
        private ?string $Date_Debut_Interruption = null,
        private ?string $Date_Fin_Interruption = null,
        private ?string $Thematique = null,
        private ?string $Sujet = null,
        private ?string $Fonctions_et_Taches = null,
        private ?string $Detail_du_Projet = null,
        private ?string $Duree_du_Stage = null,
        private ?int $Nb_de_jours_de_travail = null,
        private ?int $Nombre_d_heures_hebdomadaire = null,
        private ?float $Gratification = null,
        private ?string $Unite_Gratification = null,
        private ?string $Unite_Duree_Gratification = null,
        private ?string $Convention_Validee = null,
        private ?string $Nom_Enseignant_referent = null,
        private ?string $Prenom_Enseignant_referent = null,
        private ?string $Mail_Enseignant_referent = null,
        private ?string $Nom_Signataire = null,
        private ?string $Prenom_Signataire = null,
        private ?string $Mail_Signataire = null,
        private ?string $Fonction_Signataire = null,
        private ?string $Annee_Universitaire = null,
        private ?string $Type_de_Convention = null,
        private ?string $Commentaire_Stage = null,
        private ?string $Commentaire_Duree_Travail = null,
        private ?string $Code_ELP = null,
        private ?string $Element_pedagogique = null,
        private ?string $Code_sexe_etudiant = null,
        private ?string $Avantages_nature = null,
        private ?string $Adresse_etudiant = null,
        private ?string $Code_postal_etudiant = null,
        private ?string $Pays_etudiant = null,
        private ?string $Ville_etudiant = null,
        private ?string $Con_Vali_Peda = null,
        private ?string $Avenant_a_la_convention = null,
        private ?string $Details_Avenant = null,
        private ?string $Date_creation_conv = null,
        private ?string $Date_modi_conv = null,
        private ?string $Origine_stage = null,
        private ?string $Nom_Etablissement_d_accueil = null,
        private ?string $Siret = null,
        private ?string $Adresse_Residence = null,
        private ?string $Adresse_Voie = null,
        private ?string $Adresse_lib_cedex = null,
        private ?string $Code_Postal = null,
        private ?string $Eta_Accueil_Com = null,
        private ?string $Pays = null,
        private ?string $Statut_Juridique = null,
        private ?string $Type_de_Structure = null,
        private ?string $Effectif = null,
        private ?string $Code_NAF = null,
        private ?string $Telephone = null,
        private ?string $Fax = null,
        private ?string $Mail_Structure = null,
        private ?string $SiteWeb = null,
        private ?string $Service_d_accueil_Nom = null,
        private ?string $Service_d_accueil_Residence = null,
        private ?string $Service_d_accueil_Voie = null,
        private ?string $Service_d_accueil_Cedex = null,
        private ?string $Service_d_accueil_Code_postal = null,
        private ?string $Service_d_accueil_Commune = null,
        private ?string $Service_d_accueil_Pays = null,
        private ?string $Nom_Tuteur_Professionnel = null,
        private ?string $Prenom_Tuteur_Professionnel = null,
        private ?string $Mail_Tuteur_professionnel = null,
        private ?string $Telephone_Tuteur_Professionnel = null,
        private ?string $Fonction_Tuteur_Professionnel = null
    ) {}

    public function getIdTable(): ?int
    {
        return $this->id_table;
    }

    public function setIdTable(?int $id_table): void
    {
        $this->id_table = $id_table;
    }

}