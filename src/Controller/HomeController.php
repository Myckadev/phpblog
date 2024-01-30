<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HomeController extends AbstractController
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
        $userId = $this->sessionService->getSession('userId');
        $user = $this->userRepository->find($userId);

        return $this->render('pages/home.twig', ['isConnected' => !!$user]);
    }
}