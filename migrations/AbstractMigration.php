<?php

namespace Migrations;

use Dotenv\Dotenv;
use PDO;

abstract class AbstractMigration
{
    protected Dotenv $dotenv;
    protected PDO $pdo;
    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $this->dotenv->load();
        $dbHost = $_ENV['DATABASE_URL'];
        $dbUser = $_ENV['DATABASE_USERNAME'];
        $dbPassword = $_ENV['DATABASE_PASSWORD'];

        $this->pdo = new PDO($dbHost, $dbUser, $dbPassword);
    }

}