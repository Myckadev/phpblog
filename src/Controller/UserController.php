<?php

namespace App\Controller;

use App\Repository\UserRepository;

class UserController extends AbstractController
{

    private UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = $this->initializeRepository();
    }

    protected function initializeRepository(): UserRepository
    {
        return new UserRepository();
    }
}