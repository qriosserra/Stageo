<?php

namespace Stageo\Model\Repository;

use PDO;
use Stageo\Model\Object\CoreObject;
use Stageo\Model\Object\tableTemporaire;
use Stageo\Model\Repository\CoreRepository;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

class tableTemporaireRepository extends CoreRepository
{

    protected function getObject(): CoreObject
    {
        return new tableTemporaire();
    }

    /**
     * Fonction permettant d'insérer des données à partir d'un contenu CSV dans une table temporaire, puis d'appeler une procédure stockée pour traiter ces données.
     *
     * @param string $csvContent Contenu CSV à partir duquel les données seront insérées.
     *
     * @var PDO $conn Instance de PDO pour la connexion à la base de données.
     * @var array $csvLines Tableau contenant les lignes du fichier CSV, excluant la première ligne d'en-tête.
     * @var PDOStatement $stmt Représente une requête préparée pour l'insertion des données dans la table temporaire.
     * @var string $res Chaîne de caractères qui contient toutes les lignes du CSV concaténées.
     * @var array $data Tableau des données extraites de la chaîne CSV à l'aide de la fonction str_getcsv.
     * @var string $sqlCallProcedure Requête SQL pour appeler une procédure stockée après l'insertion des données pour triée et ranger les données.
     *
     * @throws Exception En cas d'erreur, la transaction est annulée, et l'erreur est affichée.
     */
    public function insertViaCSV(String $csvContent)
    {
        $conn = DatabaseConnection::getPdo();

        try {
            $conn->beginTransaction();

            $csvLines = explode("\n", $csvContent);

            array_shift($csvLines);

            $stmt = $conn->prepare("INSERT INTO table_temporaire VALUES (1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $res = "";
            foreach ($csvLines as $line) {

                $res .= $line;

            }
            $data = str_getcsv($res, ',');
            $stmt->execute($data);
            $conn->commit();

            $sqlCallProcedure = "CALL importationCSV()";
            $conn->query($sqlCallProcedure);

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            $conn->rollback();
        }
    }
}