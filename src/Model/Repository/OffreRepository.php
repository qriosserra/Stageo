<?php

namespace Stageo\Model\Repository;

use Exception;
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
    public function getByTextAndLocalisation (String $texte, String $localisation): ?array{
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
        $texte = (strlen($texte)>0) ?$texte : "";
        $localisation = (strlen($localisation)>0) ?$localisation : "";
        $val["text1"] = "%".$texte."%";
        $val["text2"] = "%".$texte."%";
        $val["text3"] = "%".$texte."%";
        $val["text4"] = "%".$texte."%";
        $val["localisation"] = "%".$localisation."%";

        $sql = "SELECT *
        FROM {$this->getTable()} 
        WHERE (description LIKE :text1 OR secteur LIKE :text2 OR thematique LIKE :text3 OR taches LIKE :text4)
        AND id_entreprise IN (
            SELECT t1.id_entreprise
            FROM stg_entreprise t1
            JOIN stg_distribution_commune t3 ON t1.id_distribution_commune = t3.id_distribution_commune
            WHERE t3.commune LIKE :localisation
        )";

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