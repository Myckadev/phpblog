<?php

namespace Migrations;

class Version202401202331 extends AbstractMigration implements MigrationInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function up(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL
            )
        ");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS users;");
    }

    public function description(){}
}