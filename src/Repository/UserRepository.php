<?php

namespace App\Repository;

use App\Entity\User;

class UserRepository extends AbstractRepository {

    protected function getTableName(): string
    {
        return 'user'; // Le nom de la table dans la base de données
    }

    protected function createEntity(array $data): User
    {
        return new User(...$data);
    }

    protected function getEntityFields($entity): array
    {
        /**@var User $entity*/

        return [
            'firstName' => $entity->getFirstName(),
            'lastName' => $entity->getLastName(),
            'description' => $entity->getDescription(),
            'resume' => $entity->getResume(),
            'profilPicture' => $entity->getProfilPicture(),
            'password' => $entity->getPassword(),
            'links' => $entity->getLinks(),
            'roles' => $entity->getRoles(),
        ];
    }

  
}