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
                $listeprepare[] = [
                    "tag" => ":" . htmlspecialchars(preg_replace('/[^a-zA-Z0-9]/', '', $item->getLibelle())),
                    "id" => $item->getIdCategorie(),
                    "libelle" => htmlspecialchars(preg_replace('/[^a-zA-Z0-9]/', '', $item->getLibelle()))
                ];
            }
        }

        if (isset($listeprepare)&&$listeprepare != NULL) {
            $categories = array_column($listeprepare, 'tag');


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
                $sql .= '  AND  t'.($i).'.id_categorie = ' . $listeprepare[$i]["tag"];
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