<?php

namespace App\Repository;

use App\Entity\Comment;

class CommentRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'comment';
    }

    protected function createEntity(array $data): Comment
    {
        return new Comment(...$data);
    }

    protected function getEntityFields($entity): array
    {
        // TODO: Implement getEntityFields() method.
    }
}