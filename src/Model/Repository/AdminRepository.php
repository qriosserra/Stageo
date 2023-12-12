<?php

namespace Stageo\Model\Repository;

use Stageo\Lib\Database\ComparisonOperator;
use Stageo\Lib\Database\QueryCondition;
use Stageo\Model\Object\Admin;
use Stageo\Model\Object\CoreObject;

class AdminRepository extends CoreRepository
{
    protected function getObject(): CoreObject
    {
        return new Admin();
    }

    public function getByEmail(string $email): ?CoreObject
    {
        return $this->select([new QueryCondition("email", ComparisonOperator::EQUAL, $email)])[0] ?? null;
    }

    public function updateAdmin($id,$email,$nom,$prenom,$hashed_password){
        $requete = "UPDATE `stg_admin` SET `email` = 'stageo@gmail.com', `hashed_password` = '\$argon2id\$v=19\$m=65536,t=4,p=1\$TDRqdDhoTVQuVk1ZT3k3aQ\$DkCphmrCc1JkvFhgotk3WJZ6tHPW8WAPJjo/XrgqQZM', `nom` = 'stageo', `prenom` = 'stageo' WHERE `stg_admin`.`id_admin` = 1";
        //$requete = "UPDATE `stg_admin` SET `email`=:email, `nom`:nom, `prenom`=:prenom, `hashed_password`=:hashed_password where `id_admin`=:id";
        $pdoStatement = DatabaseConnection::getPdo()->exec($requete);
        /*$values = array(
            'id' => $id,
            'email' => $email,
            'nom' => $nom,
            'prenom' => $prenom,
            'hashed_password' => $hashed_password
        );*/
        //$pdoStatement->execute($values);
    }
}