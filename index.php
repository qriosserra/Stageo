<?php

//phpinfo();
//xdebug_info();
//die();

require_once __DIR__ . "/src/Lib/Psr4AutoloaderClass.php";

$loader = new Stageo\Lib\Psr4AutoloaderClass();
$loader->addNamespace("Stageo", __DIR__ . "/src");
$loader->register();

(new Stageo\Lib\Request)->process(
    controller: $_GET["c"] ?? "main",
    action: $_GET["a"] ?? "home",
    params: $_GET
);