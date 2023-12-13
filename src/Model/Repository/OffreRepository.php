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

    public function getAllValideOffreId(): ?array{
        $offres = (new OffreRepository())->select(new QueryCondition("valider", ComparisonOperator::EQUAL, 1));
        $i =0;
        foreach ( $offres as $id){
            $resulat [$i] = $id->getIdOffre();
            $i++;
        }
        return $resulat;
    }

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
                 WHERE o.valider = 0";

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
}