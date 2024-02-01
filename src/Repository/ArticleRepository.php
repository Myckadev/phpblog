<?php

namespace App\Repository;

use App\Entity\Article;
use App\Trait\ObjectKeysConverter;

class ArticleRepository extends AbstractRepository
{

    use ObjectKeysConverter;

    protected function getTableName(): string
    {
        return 'article';
    }

    protected function createEntity(array $data): Article
    {
        $transformedData = array_combine(
            array_map([$this, 'snakeCaseToCamelCase'], array_keys($data)),
            array_values($data),
        );

        return new Article(...$transformedData);
    }

    protected function getEntityFields($entity): array
    {
        /**@var Article $entity*/
        return [
            'content' => $entity->getContent(),
            'title' => $entity->getTitle(),
            'description' => $entity->getDescription(),
            'userId' => $entity->getUserId(),
            'updatedAt' => $entity->getUpdatedAt(),
        ];
    }

    public function getArticlesOrderBy(string $field, string $sense = 'DESC' | 'ASC'): array
    {
        $statement = $this->db->prepare("SELECT * FROM {$this->getTableName()} ORDER BY {$field} {$sense}");

        $statement->execute();

        $articles = [];
        foreach ($statement->fetchAll() as $object) {
            $articles[] = $this->createEntity($object);
        }

        return $articles;
    }
}