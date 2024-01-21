<?php

namespace App\Repository;

use App\Entity\Article;

class ArticleRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'article';
    }

    protected function createEntity(array $data): Article
    {
        return new Article(...$data);
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
}