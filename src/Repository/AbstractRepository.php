<?php

namespace App\Repository;

use PDO;

abstract class AbstractRepository {

    private $db;
    private $table;

    public function __construct()
    {

        $this->db = new PDO(
            $_ENV['DATABASE_URL'],
            $_ENV['DATABASE_USERNAME'],
            $_ENV['DATABASE_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        $this->table = $this->getTableName();
    }

    abstract protected function getTableName();

    public function find($id): mixed
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $statement->execute(['id' => $id]);

        if ($data = $statement->fetch()) {
            return $this->createEntity($data);
        }
        return null;
    }

    abstract protected function createEntity(array $data);

    public function save($entity): bool|string
    {
        $table = $this->getTableName();
        $fields = $this->getEntityFields($entity);

        $placeholders = array_map(function ($field) { return ":$field"; }, array_keys($fields));

        $sql = sprintf("INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(", ", array_keys($fields)),
            implode(", ", $placeholders)
        );

        $stmt = $this->db->prepare($sql);
        
        foreach ($fields as $field => $value) {
            $stmt->bindValue(":$field", $value);
        }

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    abstract protected function getEntityFields($entity): array;

}