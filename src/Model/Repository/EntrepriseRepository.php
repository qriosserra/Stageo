<?php

namespace Stageo\Model\Repository;

use PDO;
use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\Entreprise;

class EntrepriseRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Entreprise();
    }

    public function getById(int $id): ?CoreObject
    {
        return $this->select([new QueryCondition("id_entreprise", ComparisonOperator::EQUAL, $id)])[0] ?? null;
    }

    public function getByEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }

    public function getByUnverifiedEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("unverified_email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }

    function getOffreEntreprise($id_entreprise){
        $query = "Select o.id_offre,count(p.login)
        from stg_entreprise e
        join stg_offre o on o.id_entreprise = e.id_entreprise
        join stg_postuler p on p.id_offre=o.id_offre
        WHERE e.id_entreprise = :id_entreprise
        GROUP BY o.id_offre";

        $pdo = DatabaseConnection::getPdo();
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_entreprise', $id_entreprise, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $offre = [];

        foreach ($result as $row) {
            $offre[] = $row['id_offre'];
        }

        return ['offre' => $offre];
    }
    /*
     * recupere toutes les entreprises non Valider
     */
    function getEntreprisesNonValidees() {
        try {
            $query = "SELECT e.id_entreprise, e.email, e.raison_sociale, e.siret, e.numero_voie, e.code_naf, e.telephone, e.fax, e.site, e.valide,
                          ts.libelle AS taille_entreprise, tlibelle.libelle AS type_structure, sj.libelle AS statut_juridique,
                          dc.commune AS commune, dc.code_postal, dc.id_pays, p.nom AS pays
                   FROM stg_entreprise e
                        LEFT JOIN stg_taille_entreprise ts ON e.id_taille_entreprise = ts.id_taille_entreprise
                        LEFT JOIN stg_type_structure tlibelle ON e.id_type_structure = tlibelle.id_type_structure
                        LEFT JOIN stg_statut_juridique sj ON e.id_statut_juridique = sj.id_statut_juridique
                        LEFT JOIN stg_distribution_commune dc ON e.id_distribution_commune = dc.id_distribution_commune
                        LEFT JOIN stg_pays p ON dc.id_pays = p.id_pays
                   WHERE e.valide = 0 AND e.email IS NOT NULL AND e.email != ''";
            $pdo= DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    function deleteEnterpriseFromArchive($id_entreprise) {
        try {
            $query = "DELETE FROM stg_entreprise_archive WHERE id_entreprise = :id_entreprise";
            $pdo = DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id_entreprise', $id_entreprise, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /*
     * recupere toute les entreprises archiver
     */
    function getEntreprisesAchive() {
        try {
            $query = "SELECT 
                        ea.id_entreprise,
                        ea.email,
                        ea.raison_sociale,
                        ea.siret,
                        ea.numero_voie,
                        ea.code_naf,
                        ea.telephone,
                        ea.fax,
                        ea.site,
                        ea.valide,
                        te.libelle AS taille_entreprise,
                        ts.libelle AS type_structure,
                        sj.libelle AS statut_juridique,
                        dc.code_postal,
                        dc.commune,
                        p.nom AS pays
                    FROM
                        stg_entreprise_archive ea
                    LEFT JOIN stg_taille_entreprise te ON ea.id_taille_entreprise = te.id_taille_entreprise
                    LEFT JOIN stg_type_structure ts ON ea.id_type_structure = ts.id_type_structure
                    LEFT JOIN stg_statut_juridique sj ON ea.id_statut_juridique = sj.id_statut_juridique
                    LEFT JOIN stg_distribution_commune dc ON ea.id_distribution_commune = dc.id_distribution_commune
                    LEFT JOIN stg_pays p ON dc.id_pays = p.id_pays;
                    ";
            $pdo= DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Fonction qui récupère les détails des entreprises depuis la base de données. La requête SQL joint plusieurs tables pour obtenir
     * des informations détaillées sur chaque entreprise, telles que l'identifiant, l'email, la raison sociale, le SIRET, l'adresse,
     * le code NAF, le téléphone, le fax, le site web, la validation, la taille de l'entreprise, le type de structure, le statut juridique,
     * la commune, le code postal, l'identifiant du pays et le nom du pays.
     *
     * @return array|false Un tableau associatif contenant les détails des entreprises, ou false en cas d'erreur lors de l'exécution de la requête.
     *
     * @throws PDOException En cas d'erreur lors de l'exécution de la requête SQL, une exception PDO est attrapée, affichant le message d'erreur.
     *
     * @var string $query Requête SQL pour récupérer les détails des entreprises en utilisant des jointures.
     * @var PDO $pdo Instance de l'objet PDO pour la connexion à la base de données.
     * @var PDOStatement $stmt Instance de l'objet PDOStatement pour préparer et exécuter la requête SQL.
     * @var array $result Résultat de la requête, un tableau associatif contenant les détails des entreprises.
     */
    public function getEntrepriseDetails() {
        try {
            $query = "SELECT e.id_entreprise, e.email, e.raison_sociale, e.siret, e.numero_voie, e.code_naf, e.telephone, e.fax, e.site, e.valide,
                          ts.libelle AS taille_entreprise, tlibelle.libelle AS type_structure, sj.libelle AS statut_juridique,
                          dc.commune AS commune, dc.code_postal, dc.id_pays, p.nom AS pays
                   FROM stg_entreprise e
                        LEFT JOIN stg_taille_entreprise ts ON e.id_taille_entreprise = ts.id_taille_entreprise
                        LEFT JOIN stg_type_structure tlibelle ON e.id_type_structure = tlibelle.id_type_structure
                        LEFT JOIN stg_statut_juridique sj ON e.id_statut_juridique = sj.id_statut_juridique
                        LEFT JOIN stg_distribution_commune dc ON e.id_distribution_commune = dc.id_distribution_commune
                        LEFT JOIN stg_pays p ON dc.id_pays = p.id_pays";
            $pdo= DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    /**
     * Fonction qui récupère les détails d'une entreprise spécifique à partir de son identifiant.
     * La requête SQL joint plusieurs tables pour obtenir des informations détaillées sur l'entreprise ciblée, telles que
     * l'identifiant, l'email, la raison sociale, le SIRET, l'adresse, le code NAF, le téléphone, le fax, le site web, la validation,
     * la taille de l'entreprise, le type de structure, le statut juridique, la commune, le code postal, l'identifiant du pays et le nom du pays.
     *
     * @param int $id L'identifiant de l'entreprise dont on souhaite récupérer les détails.
     *
     * @return array|false Un tableau associatif contenant les détails de l'entreprise, ou false en cas d'erreur lors de l'exécution de la requête.
     *
     * @throws PDOException En cas d'erreur lors de l'exécution de la requête SQL, une exception PDO est attrapée, affichant le message d'erreur.
     *
     * @var string $query Requête SQL pour récupérer les détails d'une entreprise spécifique en utilisant des jointures et une clause WHERE sur l'identifiant.
     * @var PDO $pdo Instance de l'objet PDO pour la connexion à la base de données.
     * @var PDOStatement $stmt Instance de l'objet PDOStatement pour préparer et exécuter la requête SQL.
     * @var array $tab Tableau associatif contenant l'identifiant de l'entreprise, utilisé pour remplacer le paramètre de requête nommé ":idTag".
     * @var array $result Résultat de la requête, un tableau associatif contenant les détails de l'entreprise ciblée.
     */
    public function getEntrepriseDetailsById($id) {
        try {
            $query = "SELECT e.id_entreprise, e.email, e.raison_sociale, e.siret, e.numero_voie, e.code_naf, e.telephone, e.fax, e.site, e.valide,
                          ts.libelle AS taille_entreprise, tlibelle.libelle AS type_structure, sj.libelle AS statut_juridique,
                          dc.commune AS commune, dc.code_postal, dc.id_pays, p.nom AS pays
                   FROM stg_entreprise e
                        LEFT JOIN stg_taille_entreprise ts ON e.id_taille_entreprise = ts.id_taille_entreprise
                        LEFT JOIN stg_type_structure tlibelle ON e.id_type_structure = tlibelle.id_type_structure
                        LEFT JOIN stg_statut_juridique sj ON e.id_statut_juridique = sj.id_statut_juridique
                        LEFT JOIN stg_distribution_commune dc ON e.id_distribution_commune = dc.id_distribution_commune
                        LEFT JOIN stg_pays p ON dc.id_pays = p.id_pays
                        WHERE e.id_entreprise = :idTag";
            $pdo= DatabaseConnection::getPdo();
            $stmt = $pdo->prepare($query);
            $tab = [
              "idTag" => $id,
            ];
            $stmt->execute($tab);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}