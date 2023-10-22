<?php

use Stageo\Model\Repository\CodePostalCommuneRepository;
use Stageo\Model\Repository\CommuneRepository;

require_once __DIR__ . "/../../src/Lib/Psr4AutoloaderClass.php";

$loader = new Stageo\Lib\Psr4AutoloaderClass();
$loader->addNamespace("Stageo", __DIR__ . "/../../src");
$loader->register();

$input = $_GET["commune"] ?? null;
$limit = $_GET["limit"] ?? 5;

$communes = (new CommuneRepository())->getByName($input, $limit);

// délai fictif
//sleep(1);

// affichage en format JSON du résultat précédent
echo json_encode($communes);