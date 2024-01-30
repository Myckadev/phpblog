<?php

namespace App\Repository;

use App\Entity\User;
use App\Trait\ObjectKeysConverter;

class UserRepository extends AbstractRepository {

    use ObjectKeysConverter;

    protected function getTableName(): string
    {
        return 'user'; // Le nom de la table dans la base de données
    }

    protected function createEntity(array $data): User
    {
        $transformedData = array_combine(
            array_map([$this, 'snakeCaseToCamelCase'], array_keys($data)),
            array_values($data)
        );

        return new User(...$transformedData);
    }

    protected function getEntityFields($entity): array
    {
        /**@var User $entity*/

        return [
            'email' => $entity->getEmail(),
            'first_name' => $entity->getFirstName(),
            'last_name' => $entity->getLastName(),
            'description' => $entity->getDescription(),
            'resume' => $entity->getResume(),
            'profil_picture' => $entity->getProfilPicture(),
            'password' => password_hash($entity->getPassword(), PASSWORD_DEFAULT),
            'links' => $entity->getLinks(),
            'roles' => $entity->getRoles(),
        ];
    }

}