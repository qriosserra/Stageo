<?php

namespace Stageo\Model\Repository;

use Exception;
use PDO;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Offre;

class OffreRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Offre();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
    public function getAllOffreId(): ?array{
        $offres = (new OffreRepository())->select();
        $i =0;
        foreach ( $offres as $id){
            $resulat [$i] = $id->getIdOffre();
            $i++;
        }
        return $resulat;
    }

    /**
     * Récupère les identifiants de toutes les offres validées.
     *
     * @return array|null Un tableau contenant les identifiants des offres validées, ou null en cas d'erreur.
     *
     */
    public function getAllValideOffreId(): ?array{
        $offres = (new OffreRepository())->select(new QueryCondition("valider", ComparisonOperator::EQUAL, 1));
        $i =0;
        foreach ( $offres as $id){
            $resulat [$i] = $id->getIdOffre();
            $i++;
        }
        return $resulat;
    }

    /**
     * Récupère toutes les offres non validées associées à une entreprise spécifiée.
     *
     * @param int $identreprise Identifiant de l'entreprise
     *
     * @return array|false Tableau associatif des offres avec leurs catégories, ou false en cas d'erreur.
     */
    public function getAllInvalidOffreEntreprise($identreprise) {try {
        $query = "SELECT 
                    o.id_offre,
                    o.type,
                    o.description,
                    o.thematique,
                    o.secteur,
                    o.taches,
                    o.commentaires,
                    o.gratification,
                    o.login,
                    o.id_unite_gratification,
                    o.id_entreprise,
                    e.email AS entreprise_email,
                    e.raison_sociale,
                    e.siret,
                    e.numero_voie AS entreprise_numero_voie,
                    e.code_naf,
                    e.telephone AS entreprise_telephone,
                    e.fax AS entreprise_fax,
                    e.site AS entreprise_site,
                    e.id_taille_entreprise,
                    e.id_type_structure,
                    e.id_statut_juridique,
                    e.id_distribution_commune AS entreprise_id_commune,
                    c.commune AS entreprise_commune,
                    tc.libelle AS taille_entreprise_libelle,
                    tsj.libelle AS statut_juridique_libelle,
                    ts.libelle AS type_structure_libelle,
                    cat.id_categorie,
                    cat.libelle AS categorie_libelle
                 FROM stg_offre o
                 JOIN stg_entreprise e ON o.id_entreprise = e.id_entreprise
                 LEFT JOIN stg_distribution_commune c ON e.id_distribution_commune = c.id_distribution_commune
                 LEFT JOIN stg_taille_entreprise tc ON e.id_taille_entreprise = tc.id_taille_entreprise
                 LEFT JOIN stg_statut_juridique tsj ON e.id_statut_juridique = tsj.id_statut_juridique
                 LEFT JOIN stg_type_structure ts ON e.id_type_structure = ts.id_type_structure
                 LEFT JOIN stg_offre_categorie oc ON o.id_offre = oc.id_offre
                 LEFT JOIN stg_categorie cat ON oc.id_categorie = cat.id_categorie
                 WHERE o.valider = 0 AND e.id_entreprise= :identr";

        $values["identr"] = $identreprise;
        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->execute($values);

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organiser les résultats par id_offre
        $offresAvecCategories = [];
        foreach ($result as $row) {
            $idOffre = $row['id_offre'];
            if (!isset($offresAvecCategories[$idOffre])) {
                // Initialiser les données de l'offre
                $offresAvecCategories[$idOffre] = [
                    "id_offre" => $idOffre,
                    "description" => $row['description'],
                    "thematique" => $row['thematique'],
                    "taches" => $row['taches'],
                    "type" =>$row['type'],
                    "raison_sociale" =>$row['raison_sociale'],
                    "email" =>$row['entreprise_email'],
                    "categories" => [],
                ];
            }

            // Ajouter la catégorie associée à cette offre
            $offresAvecCategories[$idOffre]['categories'][] = [
                "id_categorie" => $row['id_categorie'],
                "libelle" => $row['categorie_libelle'],
            ];
        }

        // Convertir l'array associatif en array simple
        return array_values($offresAvecCategories);

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
    }

    /**
     * Fonction qui récupère les détails de toutes les offres non validées avec les informations de l'entreprise associée.
     *
     * @return array|false Un tableau contenant les détails des offres non validées, incluant les informations de l'entreprise et les catégories associées, ou false en cas d'erreur.
     *
     * @throws PDOException En cas d'erreur lors de l'exécution de la requête SQL, une exception PDO est attrapée, affichant le message d'erreur.
     *
     * @var array|false $result Résultats de la requête SQL sous forme de tableau associatif.
     * @var array $offresAvecCategories Tableau associatif organisant les offres par leur identifiant avec les informations de l'entreprise et les catégories associées.
     * @var int $idOffre Identifiant de l'offre en cours de traitement.
     * @var array|false $categories Tableau associatif contenant les informations de la catégorie associée à l'offre.
     */
    public function getAllInvalidOffre() {try {
        $query = "SELECT 
                    o.id_offre,
                    o.type,
                    o.description,
                    o.thematique,
                    o.secteur,
                    o.taches,
                    o.commentaires,
                    o.gratification,
                    o.login,
                    o.id_unite_gratification,
                    o.id_entreprise,
                    e.email AS entreprise_email,
                    e.raison_sociale,
                    e.siret,
                    e.numero_voie AS entreprise_numero_voie,
                    e.code_naf,
                    e.telephone AS entreprise_telephone,
                    e.fax AS entreprise_fax,
                    e.site AS entreprise_site,
                    e.id_taille_entreprise,
                    e.id_type_structure,
                    e.id_statut_juridique,
                    e.id_distribution_commune AS entreprise_id_commune,
                    c.commune AS entreprise_commune,
                    tc.libelle AS taille_entreprise_libelle,
                    tsj.libelle AS statut_juridique_libelle,
                    ts.libelle AS type_structure_libelle,
                    cat.id_categorie,
                    cat.libelle AS categorie_libelle
                 FROM stg_offre o
                 JOIN stg_entreprise e ON o.id_entreprise = e.id_entreprise
                 LEFT JOIN stg_distribution_commune c ON e.id_distribution_commune = c.id_distribution_commune
                 LEFT JOIN stg_taille_entreprise tc ON e.id_taille_entreprise = tc.id_taille_entreprise
                 LEFT JOIN stg_statut_juridique tsj ON e.id_statut_juridique = tsj.id_statut_juridique
                 LEFT JOIN stg_type_structure ts ON e.id_type_structure = ts.id_type_structure
                 LEFT JOIN stg_offre_categorie oc ON o.id_offre = oc.id_offre
                 LEFT JOIN stg_categorie cat ON oc.id_categorie = cat.id_categorie
                 WHERE o.valider = 0 AND e.valide = 1";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Organiser les résultats par id_offre
        $offresAvecCategories = [];
        foreach ($result as $row) {
            $idOffre = $row['id_offre'];
            if (!isset($offresAvecCategories[$idOffre])) {
                // Initialiser les données de l'offre
                $offresAvecCategories[$idOffre] = [
                    "id_offre" => $idOffre,
                    "description" => $row['description'],
                    "thematique" => $row['thematique'],
                    "taches" => $row['taches'],
                    "type" =>$row['type'],
                    "raison_sociale" =>$row['raison_sociale'],
                    "email" =>$row['entreprise_email'],
                    "categories" => [],
                ];
            }

            // Ajouter la catégorie associée à cette offre
            $offresAvecCategories[$idOffre]['categories'][] = [
                "id_categorie" => $row['id_categorie'],
                "libelle" => $row['categorie_libelle'],
            ];
        }

        // Convertir l'array associatif en array simple
        return array_values($offresAvecCategories);

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
    }

    /**
     * Fonction qui récupère les détails de toutes les offres validées avec les informations de l'entreprise associée et les catégories associées.
     *
     * @return array|false Un tableau contenant les détails des offres validées, incluant les informations de l'entreprise et les catégories associées, ou false en cas d'erreur.
     *
     * @throws PDOException En cas d'erreur lors de l'exécution de la requête SQL, une exception PDO est attrapée, affichant le message d'erreur.
     *
     * @var array|false $result Résultats de la requête SQL sous forme de tableau associatif.
     * @var array $offresAvecCategories Tableau associatif organisant les offres par leur identifiant avec les informations de l'entreprise et les catégories associées.
     * @var int $idOffre Identifiant de l'offre en cours de traitement.
     * @var array|false $categories Tableau associatif contenant les informations de la catégorie associée à l'offre.
     */
    function getOffresDetailsAvecCategories() {
        try {
            $query = "SELECT 
                    o.id_offre,
                    o.type,
                    o.description,
                    o.thematique,
                    o.secteur,
                    o.taches,
                    o.commentaires,
                    o.gratification,
                    o.login,
                    o.id_unite_gratification,
                    o.id_entreprise,
                    e.email AS entreprise_email,
                    e.raison_sociale,
                    e.siret,
                    e.numero_voie AS entreprise_numero_voie,
                    e.code_naf,
                    e.telephone AS entreprise_telephone,
                    e.fax AS entreprise_fax,
                    e.site AS entreprise_site,
                    e.id_taille_entreprise,
                    e.id_type_structure,
                    e.id_statut_juridique,
                    e.id_distribution_commune AS entreprise_id_commune,
                    c.commune AS entreprise_commune,
                    tc.libelle AS taille_entreprise_libelle,
                    tsj.libelle AS statut_juridique_libelle,
                    ts.libelle AS type_structure_libelle,
                    cat.id_categorie,
                    cat.libelle AS categorie_libelle
                 FROM stg_offre o
                 JOIN stg_entreprise e ON o.id_entreprise = e.id_entreprise
                 LEFT JOIN stg_distribution_commune c ON e.id_distribution_commune = c.id_distribution_commune
                 LEFT JOIN stg_taille_entreprise tc ON e.id_taille_entreprise = tc.id_taille_entreprise
                 LEFT JOIN stg_statut_juridique tsj ON e.id_statut_juridique = tsj.id_statut_juridique
                 LEFT JOIN stg_type_structure ts ON e.id_type_structure = ts.id_type_structure
                 LEFT JOIN stg_offre_categorie oc ON o.id_offre = oc.id_offre
                 LEFT JOIN stg_categorie cat ON oc.id_categorie = cat.id_categorie
                 WHERE o.valider = 1";

            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organiser les résultats par id_offre
            $offresAvecCategories = [];
            foreach ($result as $row) {
                $idOffre = $row['id_offre'];
                if (!isset($offresAvecCategories[$idOffre])) {
                    // Initialiser les données de l'offre
                    $offresAvecCategories[$idOffre] = [
                        "id_offre" => $idOffre,
                        "description" => $row['description'],
                        "thematique" => $row['thematique'],
                        "taches" => $row['taches'],
                        "type" =>$row['type'],
                        "raison_sociale" =>$row['raison_sociale'],
                        "categories" => [],
                    ];
                }

                // Ajouter la catégorie associée à cette offre
                $offresAvecCategories[$idOffre]['categories'][] = [
                    "id_categorie" => $row['id_categorie'],
                    "libelle" => $row['categorie_libelle'],
                ];
            }

            // Convertir l'array associatif en array simple
            return array_values($offresAvecCategories);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Fonction qui récupère les détails des offres validées pour une entreprise spécifique avec les informations de l'entreprise associée et les catégories.
     *
     * @param int|string $id Identifiant de l'entreprise pour laquelle récupérer les offres.
     * @return array|false Un tableau contenant les détails des offres validées pour l'entreprise spécifiée, incluant les informations de l'entreprise et les catégories associées, ou false en cas d'erreur.
     *
     * @throws PDOException En cas d'erreur lors de l'exécution de la requête SQL, une exception PDO est attrapée, affichant le message d'erreur.
     *
     * @var array|false $result Résultats de la requête SQL sous forme de tableau associatif.
     * @var array $offresAvecCategories Tableau associatif organisant les offres par leur identifiant avec les informations de l'entreprise et les catégories associées.
     * @var int $idOffre Identifiant de l'offre en cours de traitement.
     * @var array|false $categories Tableau associatif contenant les informations de la catégorie associée à l'offre.
     */
    function getOffresDetailsAvecCategoriesByIdEntreprise($id) {
        try {
            $query = "SELECT 
                    o.id_offre,
                    o.type,
                    o.description,
                    o.thematique,
                    o.secteur,
                    o.taches,
                    o.commentaires,
                    o.gratification,
                    o.login,
                    o.id_unite_gratification,
                    o.id_entreprise,
                    e.email AS entreprise_email,
                    e.raison_sociale,
                    e.siret,
                    e.numero_voie AS entreprise_numero_voie,
                    e.code_naf,
                    e.telephone AS entreprise_telephone,
                    e.fax AS entreprise_fax,
                    e.site AS entreprise_site,
                    e.id_taille_entreprise,
                    e.id_type_structure,
                    e.id_statut_juridique,
                    e.id_distribution_commune AS entreprise_id_commune,
                    c.commune AS entreprise_commune,
                    tc.libelle AS taille_entreprise_libelle,
                    tsj.libelle AS statut_juridique_libelle,
                    ts.libelle AS type_structure_libelle,
                    cat.id_categorie,
                    cat.libelle AS categorie_libelle
                 FROM stg_offre o
                 JOIN stg_entreprise e ON o.id_entreprise = e.id_entreprise
                 LEFT JOIN stg_distribution_commune c ON e.id_distribution_commune = c.id_distribution_commune
                 LEFT JOIN stg_taille_entreprise tc ON e.id_taille_entreprise = tc.id_taille_entreprise
                 LEFT JOIN stg_statut_juridique tsj ON e.id_statut_juridique = tsj.id_statut_juridique
                 LEFT JOIN stg_type_structure ts ON e.id_type_structure = ts.id_type_structure
                 LEFT JOIN stg_offre_categorie oc ON o.id_offre = oc.id_offre
                 LEFT JOIN stg_categorie cat ON oc.id_categorie = cat.id_categorie
                 WHERE o.id_entreprise LIKE :idTag";

            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $rep = [
                "idTag" => $id
            ];
            $stmt->execute($rep);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organiser les résultats par id_offre
            $offresAvecCategories = [];
            foreach ($result as $row) {
                $idOffre = $row['id_offre'];
                if (!isset($offresAvecCategories[$idOffre])) {
                    // Initialiser les données de l'offre
                    $offresAvecCategories[$idOffre] = [
                        "id_offre" => $idOffre,
                        "description" => $row['description'],
                        "thematique" => $row['thematique'],
                        "taches" => $row['taches'],
                        "type" =>$row['type'],
                        "raison_sociale" =>$row['raison_sociale'],
                        "categories" => [],
                    ];
                }

                // Ajouter la catégorie associée à cette offre
                $offresAvecCategories[$idOffre]['categories'][] = [
                    "id_categorie" => $row['id_categorie'],
                    "libelle" => $row['categorie_libelle'],
                ];
            }

            // Convertir l'array associatif en array simple
            return array_values($offresAvecCategories);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }



    /**
     * Fonction qui récupère les offres en fonction d'un texte, d'une localisation et d'un type spécifié.
     *
     * @param string $texte Texte à rechercher dans les champs description, secteur, thematique, et taches des offres.
     * @param string $localisation Localisation à rechercher parmi les communes des entreprises associées aux offres.
     * @param array $Togle Tableau de deux valeurs (alternance et stage) déterminant le type d'offres à rechercher.
     * @return array Un tableau d'objets représentant les offres correspondant aux critères de recherche, ou un tableau vide si aucune offre n'est trouvée.
     *
     * @var string $toglle Condition de recherche basée sur les valeurs du tableau $Togle pour déterminer le type d'offres à rechercher.
     * @var string $texte Valeur du texte à rechercher, préfixée et suffixée par '%'.
     * @var string $localisation Valeur de la localisation à rechercher, préfixée et suffixée par '%'.
     * @var array $val Tableau associatif contenant les valeurs des paramètres à substituer dans la requête SQL.
     * @var string $sql Requête SQL permettant de récupérer les offres en fonction des critères spécifiés.
     * @var PDOStatement $pdo Représente une requête préparée et exécutée.
     * @var array|false $objectArray Résultats de la requête SQL sous forme de tableau associatif.
     * @var array $objects Tableau d'objets représentant les offres correspondant aux critères de recherche.
     */
    public function getByTextAndLocalisation (String $texte, String $localisation, array $Togle): ?array{
       /* $val ["text1"] = $texte;
        $val ["text2"] = $texte;
        $val ["text3"] = $texte;
        $val ["text4"] = $texte;
        $val ["localisation"] = $localisation;
        $sql = "SELECT *
                FROM {$this->getTable()} 
                WHERE description = '% :text1 %' OR secteur = '% :text2 %' OR thematique = '% :text3 %' OR taches = '% :text4 %' AND id_unite_gratification = (
                SELECT DISTINCT id_unite_gratification
                FROM Convention t1 JOIN stg_unite_gratification t2   ON t1.id_unite_gratification = t2.id_unite_gratification JOIN stg_distribution_commune t3 ON t1.id_Commune = t3.id_commune
                WHERE t3.commune =  '% :localisation %'
                )";
        $pdo = DatabaseConnection::getPdo()->prepare($sql);
        $pdo->execute($val);*/
        $toglle = ($Togle[0] == "oui" && $Togle[1] == "oui") ? "%%"
            : ($Togle[0] == "oui" ? "%Alternance%"
                : ($Togle[1] == "oui" ? "%Stage%" : "%%"));

        $texte = (strlen($texte)>0) ?$texte : "";
        $localisation = (strlen($localisation)>0) ?$localisation : "";
        $val["text1"] = "%".$texte."%";
        $val["text2"] = "%".$texte."%";
        $val["text3"] = "%".$texte."%";
        $val["text4"] = "%".$texte."%";
        $val["localisation"] = "%".$localisation."%";
        $val["Togle"] = $toglle;
        $sql = "SELECT *
        FROM {$this->getTable()} 
        WHERE (description LIKE :text1 OR secteur LIKE :text2 OR thematique LIKE :text3 OR taches LIKE :text4)
        AND valider = 1 AND id_entreprise IN (
            SELECT t1.id_entreprise
            FROM stg_entreprise t1
            JOIN stg_distribution_commune t3 ON t1.id_distribution_commune = t3.id_distribution_commune
            WHERE t3.commune LIKE :localisation 
        ) AND type LIKE :Togle";

        $pdo = DatabaseConnection::getPdo()->prepare($sql);
        $pdo->execute($val);
        $objectArray = $pdo->fetchAll();

        foreach ($objectArray as $toto) {
            if ($toto != NULL){
                $objects[] =$this->getObject()->construct($toto);
            }
        }
        return $objects ?? [];
    }

public static function getOffersArchive() {
        try {
            $query = "SELECT 
                        oa.id_offre,
                        oa.description,
                        oa.thematique,
                        oa.secteur,
                        oa.taches,
                        oa.commentaires,
                        oa.gratification,
                        oa.type,
                        oa.date_debut,
                        oa.date_fin,
                        oa.niveau,
                        oa.valider,
                        oa.valider_par_etudiant,
                        e.login AS login_etudiant,
                        ug.libelle AS unite_gratification,
                        ea.id_entreprise,
                        ea.email AS entreprise_email,
                        ea.raison_sociale,
                        ea.siret,
                        ea.numero_voie AS entreprise_numero_voie,
                        ea.code_naf,
                        ea.telephone AS entreprise_telephone,
                        ea.fax AS entreprise_fax,
                        ea.site AS entreprise_site,
                        ea.id_taille_entreprise,
                        ea.id_type_structure,
                        ea.id_statut_juridique,
                        dc.id_distribution_commune AS entreprise_id_commune,
                        dc.commune AS entreprise_commune,
                        tc.libelle AS taille_entreprise_libelle,
                        tsj.libelle AS statut_juridique_libelle,
                        ts.libelle AS type_structure_libelle,
                        cat.id_categorie,
                        cat.libelle AS categorie_libelle
                    FROM stg_offre_archive oa
                    LEFT JOIN stg_etudiant e ON oa.login = e.login
                    LEFT JOIN stg_unite_gratification ug ON oa.id_unite_gratification = ug.id_unite_gratification
                    LEFT JOIN stg_entreprise_archive ea ON oa.id_entreprise = ea.id_entreprise
                    LEFT JOIN stg_distribution_commune dc ON ea.id_distribution_commune = dc.id_distribution_commune
                    LEFT JOIN stg_taille_entreprise tc ON ea.id_taille_entreprise = tc.id_taille_entreprise
                    LEFT JOIN stg_statut_juridique tsj ON ea.id_statut_juridique = tsj.id_statut_juridique
                    LEFT JOIN stg_type_structure ts ON ea.id_type_structure = ts.id_type_structure
                    LEFT JOIN stg_offre_categorie oc ON oa.id_offre = oc.id_offre
                    LEFT JOIN stg_categorie cat ON oc.id_categorie = cat.id_categorie;
                    ";

            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organiser les résultats par id_offre
            $offresAvecCategories = [];
            foreach ($result as $row) {
                $idOffre = $row['id_offre'];
                if (!isset($offresAvecCategories[$idOffre])) {
                    // Initialiser les données de l'offre
                    $offresAvecCategories[$idOffre] = [
                        "id_offre" => $idOffre,
                        "description" => $row['description'],
                        "thematique" => $row['thematique'],
                        "taches" => $row['taches'],
                        "type" =>$row['type'],
                        "raison_sociale" =>$row['raison_sociale'],
                        "email" =>$row['entreprise_email'],
                        "categories" => [],
                    ];
                }

                // Ajouter la catégorie associée à cette offre
                $offresAvecCategories[$idOffre]['categories'][] = [
                    "id_categorie" => $row['id_categorie'],
                    "libelle" => $row['categorie_libelle'],
                ];
            }

            // Convertir l'array associatif en array simple
            return array_values($offresAvecCategories);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    function getEtudiantsByOffreId($id_offre) {
        try {
            $query = "SELECT etudiant.*
                      FROM stg_etudiant etudiant
                      JOIN stg_postuler postuler ON etudiant.login = postuler.login
                      WHERE postuler.id_offre = :id_offre";

            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($result);
            die();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function deleteOfferFromArchive($id_offre) {
        try {
            $query = "DELETE FROM stg_offre_archive WHERE id_offre = :id_offre";
            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_offre', $id_offre, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Fonction qui récupère les détails des offres archivées avec leurs catégories associées pour une entreprise spécifiée.
     *
     * @param int $id Identifiant de l'entreprise pour laquelle récupérer les offres archivées.
     * @return array|false Un tableau d'objets représentant les détails des offres archivées avec leurs catégories associées pour l'entreprise spécifiée, ou false en cas d'erreur.
     *
     * @var array $rep Tableau associatif contenant l'identifiant de l'entreprise à substituer dans la requête SQL.
     * @var array|false $result Résultats de la requête SQL sous forme de tableau associatif.
     * @var array $offresAvecCategories Tableau associatif pour organiser les résultats par id_offre.
     */
    function getOffresDetailsAvecCategoriesByIdEntrepriseArchive($id) {
        try {
            $query = "SELECT 
                oa.id_offre,
                oa.description,
                oa.thematique,
                oa.taches,
                oa.type,
                ea.raison_sociale,
                c.cat_id AS id_categorie,
                cat.libelle AS categorie_libelle
             FROM stg_offre_archive oa
             JOIN stg_entreprise_archive ea ON oa.id_entreprise = ea.id_entreprise
             LEFT JOIN (
                 SELECT oc.id_offre, GROUP_CONCAT(c.id_categorie) AS cat_id
                 FROM stg_offre_categorie oc
                 JOIN stg_categorie c ON oc.id_categorie = c.id_categorie
                 GROUP BY oc.id_offre
             ) c ON oa.id_offre = c.id_offre
             LEFT JOIN stg_categorie cat ON FIND_IN_SET(cat.id_categorie, c.cat_id)
             WHERE oa.id_entreprise = :idTag";

            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $rep = [
                "idTag" => $id
            ];
            $stmt->execute($rep);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Organiser les résultats par id_offre
            $offresAvecCategories = [];
            foreach ($result as $row) {
                $idOffre = $row['id_offre'];
                if (!isset($offresAvecCategories[$idOffre])) {
                    // Initialiser les données de l'offre
                    $offresAvecCategories[$idOffre] = [
                        "id_offre" => $idOffre,
                        "description" => $row['description'],
                        "thematique" => $row['thematique'],
                        "taches" => $row['taches'],
                        "type" => $row['type'],
                        "raison_sociale" => $row['raison_sociale'],
                        "categories" => [],
                    ];
                }

                // Ajouter la catégorie associée à cette offre
                $offresAvecCategories[$idOffre]['categories'][] = [
                    "id_categorie" => $row['id_categorie'],
                    "libelle" => $row['categorie_libelle'],
                ];
            }

            // Convertir l'array associatif en array simple
            return array_values($offresAvecCategories);

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

}