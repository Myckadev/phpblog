<?php

namespace Migrations;

class Version202401211945 extends AbstractMigration implements MigrationInterface
{

    public function up(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS comment (
                id INT AUTO_INCREMENT PRIMARY KEY,
                content VARCHAR(255) NOT NULL,
                article_id INT,
                user_id INT,
                FOREIGN KEY (article_id) REFERENCES article(id),
                FOREIGN KEY (user_id) REFERENCES user(id)
            )
        ");
    }

    public function down(): void
    {
        $this->pdo->exec("DROP TABLE IF EXISTS comment;");
    }

    public function description(){}
}