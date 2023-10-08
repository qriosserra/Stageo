<?php

namespace Stageo\Model\Repository;

use PDO;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=" . $_ENV["HOSTNAME"] . ";dbname=" . $_ENV["DATABASE"],
            $_ENV["DATABASE_USER"],
            $_ENV["DATABASE_PASSWORD"],
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getPdo(): PDO
    {
        return static::getInstance()->pdo;
    }

    private static function getInstance(): DatabaseConnection
    {
        if (is_null(static::$instance)) static::$instance = new DatabaseConnection();
        return static::$instance;
    }
}