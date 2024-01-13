<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\Categorie;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\DeCategorie;
use Stageo\Model\Object\Offre;
use Stageo\Model\Repository\OffreRepository;
use Stageo\Model\Repository\CoreRepository;

class DeCategorieRepository extends CoreRepository
{

    protected function getObject(): CoreObject
    {
        return new DeCategorie();
    }

    public function getByIdOffre(int $id): ?CoreObject
    {
        return $this->select(new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id))[0] ?? null;
    }
    public function getByIdOffreA(int $id): ?array
    {
        return $this->select(new QueryCondition("id_offre", ComparisonOperator::EQUAL, $id)) ?? null;
    }
    public function getByIdCategorie(int $id): ?CoreObject
    {
        return $this->select([new QueryCondition("id_categorie", ComparisonOperator::EQUAL, $id)])[0] ?? null;
    }
    public function getByIdCategorieliste(  $cate ): array
    {
        foreach ($cate as $item) {
            if (!Null && $item instanceof Categorie) {
                $listeprepare [] = ["tag" => ":" . $item->getLibelle(), "id" => $item->getIdCategorie(), "libelle" => $item->getLibelle()];
            }
        }
        /*$sql = "SELECT id_offre
            FROM {$this->getTable()}
            WHERE id_categorie = ".$listeprepare[0]["tag"];

        for ($i = 1; $i < count($listeprepare); $i++){
            $sql .= "
            Intersect 
            SELECT id_offre
            FROM {$this->getTable()}
            WHERE id_categorie = ".$listeprepare[$i]["tag"];
        }*/
        if (isset($listeprepare)&&$listeprepare != NULL) {
            $categories = array_column($listeprepare, 'tag');

// Construire la requête SQL avec des sous-requêtes
        /* $sql = "SELECT id_offre
         FROM {$this->getTable()}
         WHERE id_categorie = " . $categories[0];

         for ($i = 1; $i < count($categories); $i++) {
             $sql .= "
         INTERSECT
         SELECT id_offre
         FROM {$this->getTable()}
         WHERE id_categorie = " . $categories[$i];
         }

         $pdo = DatabaseConnection::getPdo()->prepare($sql);
         $counteur = 0;*/
        /* $categories = array_column($listeprepare, 'tag');
         $sql = "SELECT id_offre
         FROM {$this->getTable()}  t1";

         for ($i = 2; $i <= count($categories); $i++) {
             $sql .= "
         JOIN {$this->getTable()}  t$i ON t1.id_offre = t$i.id_offre
         AND t$i.id_categorie = " . $categories[$i - 1]."  AND t1.id_categorie != t$i.id_categorie ";
         }*/

        //$pdo = DatabaseConnection::getPdo()->prepare($sql);

        foreach ($listeprepare as list("libelle" => $libelle, "id" => $id)) {
            $res[$libelle] = $id;
        }
            $sql = "SELECT t0.id_offre
                FROM {$this->getTable()} t0";

            for ($i = 1; $i < count($listeprepare); $i++) {
                $sql .= "
                Join {$this->getTable()} t$i ON t0.id_offre = t$i.id_offre AND t0.id_categorie != t$i.id_categorie";
            }
            $sql .= " 
            WHERE   t0.id_categorie = " . $listeprepare[0]["tag"];
            for ($i = 1; $i < count($listeprepare); $i++) {
                $sql .= "  AND  t".($i).".id_categorie = " . $listeprepare[$i]["tag"];
            }
             $pdo = DatabaseConnection::getPdo()->prepare($sql);
             $pdo->execute($res);

            for ($objectArray = $pdo->fetch();
                 $objectArray != false;
                 $objectArray = $pdo->fetch()) {
                $objects[] = $objectArray[0];
            }
            return $objects ?? [];
        }

        return (new OffreRepository())->getAllOffreId();
    }
}