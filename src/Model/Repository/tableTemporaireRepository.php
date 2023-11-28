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
    public function insertViaCSV(String $csvContent)
    {

        /*  $file = fopen($cheminCSV, "r");

          $conn = DatabaseConnection::getPdo();

          try {
              $conn->beginTransaction();

              $stmt = $conn->prepare("INSERT INTO table_temporaire VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

              while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                  $stmt->bindParam(
                      "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
                      ...$data
                  );

                  $stmt->execute();
              }

              $conn->commit();
              fclose($file);

              $sqlCallProcedure = "CALL importationCSV()";
              $conn->query($sqlCallProcedure);

          } catch (Exception $e) {

              echo "Erreur : " . $e->getMessage();
              $conn->rollback();
          }*/
        /*  $file = fopen($cheminCSV, "r");

          $conn = DatabaseConnection::getPdo();

          try {
              $conn->beginTransaction();

              // Sauter la première ligne (en-têtes)
              fgets($file);

              // Préparation de la requête d'insertion
              $stmt = $conn->prepare("INSERT INTO table_temporaire VALUES (1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

              while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                  // Exécution de la requête avec le tableau de données
                  $stmt->execute($data);
              }

              $conn->commit();
              fclose($file);

              // Appel de la procédure stockée
              $sqlCallProcedure = "CALL importationCSV()";
              $conn->query($sqlCallProcedure);

          } catch (Exception $e) {
              // Gestion des erreurs
              echo "Erreur : " . $e->getMessage();
              $conn->rollback();
          }*/
        $conn = DatabaseConnection::getPdo();

        try {
            $conn->beginTransaction();

            $csvLines = explode("\n", $csvContent);

            array_shift($csvLines);

            $stmt = $conn->prepare("INSERT INTO table_temporaire VALUES (1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $res = "";
            foreach ($csvLines as $line) {
               // $data = str_getcsv($line, ',');

                // Bind parameters for the batch insert
                /*foreach ($data as $index => $value) {
                    $stmt->bindParam($index + 1, $value, PDO::PARAM_STR);
                }*/
               /* foreach ($data as $value) {
                    $res .= $value;
                }*/
                $res .= $line;

                // Execute the batch insert for each line
               // $stmt->execute();
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