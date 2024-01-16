<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TestController extends AbstractController
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

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function home(): Response
    {
        $hashedPassword = password_hash('1234', PASSWORD_DEFAULT);
        $user = new User(null, 'bloutime', $hashedPassword);

        $userId = $this->userRepository->save($user);

        return $this->render('base.twig', ['var' => 'Hello World', 'userId' => $userId]);
    }

    public function list()
    {
        echo 'JE SUIS LA LIST';
    
    }
}