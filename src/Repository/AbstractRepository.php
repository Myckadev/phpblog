<?php

namespace App\Repository;

use Dotenv\Dotenv;
use PDO;

abstract class AbstractRepository {

    protected $db;
    private $table;

    public function __construct()
    {
        // Initialisation du fichier d'environnement
        $dotEnv = Dotenv::createImmutable(__DIR__.'../../../', ['.env', '.env.local']);
        $dotEnv->load();

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

    abstract protected function getTableName(): string;
    abstract protected function createEntity(array $data);

    // L'utilisation de requête préparer permet d'éviter le SQL injection.
    public function find($id): mixed
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $statement->execute(['id' => $id]);

        if ($data = $statement->fetch()) {
            return $this->createEntity($data);
        }
        return null;
    }

    public function findBy(array $criteria): array
    {
        $query = "SELECT * FROM {$this->table}";
        $whereClauses = [];
        $params = [];

        foreach ($criteria as $field => $value) {
            $field = preg_replace('/[^a-z0-9_]+/i', '', $field);
            $whereClauses[] = "$field = :$field";
            $params[":$field"] = $value;
        }

        if (!empty($whereClauses)) {
            $query .= " WHERE " . implode(' AND ', $whereClauses);
        }

        $statement = $this->db->prepare($query);

        $statement->execute($params);

        $users = [];
        foreach ($statement->fetchAll() as $object) {
            $users[] = $this->createEntity($object);
        }

        return $users;
    }

    public function findOneBy(array $criteria): mixed
    {
        return isset($this->findBy($criteria)[0]) ? $this->findBy($criteria)[0] : false;
    }

    public function save(mixed $entity): bool|string
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

    public function saveAll(array $entities): bool|array
    {
        $entityIdsSaved = [];

        foreach ($entities as $entity) {
            $this->save($entity);
            $entityIdsSaved[] = $this->db->lastInsertId();
        }

        return array_unique($entityIdsSaved);
    }

    abstract protected function getEntityFields($entity): array;

}