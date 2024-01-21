<?php

namespace Migrations;

class Version202401211944 extends AbstractMigration implements MigrationInterface
{

    public function up(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS article (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT,
                description TEXT,
                updated_at DATETIME,
                user_id INT,
                FOREIGN KEY (user_id) REFERENCES user(id)
            )
        ");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS article;");
    }

    public function description(){}
}