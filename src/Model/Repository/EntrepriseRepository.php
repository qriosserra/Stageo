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
                   WHERE e.valide = 0";
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
}