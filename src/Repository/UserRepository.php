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
        return new User($data['id'], $data['username'], $data['password']);
    }

    protected function getEntityFields($user): array {
        return [
            'username' => $user->getUsername(),
            'password' => $user->getPassword() 
        ];
    }

  
}