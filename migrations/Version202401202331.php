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
            CREATE TABLE IF NOT EXISTS user (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(50) NOT NULL,
                last_name VARCHAR(50) NOT NULL,
                description TEXT,
                resume VARCHAR(255),
                profil_picture VARCHAR(255),
                password VARCHAR(255) NOT NULL,
                links JSON,
                roles JSON
            )
        ");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS user;");
    }

    public function description(){}
}