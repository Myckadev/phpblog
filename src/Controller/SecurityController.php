<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SecurityController extends AbstractController
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
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function login(): Response
    {
        return $this->render('pages/login.twig');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function doLogin(): Response | RedirectResponse
    {
        try {
            return $this->handleForm(
                validateForm: function () {
                    if ($this->sessionService->getSession('userId')) {
                        throw new \Exception('Already connected', code: 404);
                    }

                    $postData = $this->requestService->getBody('email', 'password');
                    $user = $this->userRepository->findOneBy(['email' => $postData['email']]);
                    if (!$user || !password_verify($postData['password'], $user->getPassword())) {
                        throw new \Exception('Invalid Credentials', code: 404);
                    } else {
                        return $user;
                    }
                },
                onSuccess: function ($result) {
                    $this->sessionService->ensureStarted();
                    $this->sessionService->createSession('userId', $result->getId());

                    return $this->redirect('/phpblog/');
                },
            );
        } catch (\Exception $exception) {
            return $this->render('error.twig', args: ['message' => $exception->getMessage()], statusCode: $exception->getCode());
        }
    }

    public function logout(): RedirectResponse
    {
        $this->sessionService->destroySession();

        return $this->redirect('/phpblog/');
    }


    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function register(): Response
    {
        return $this->render('pages/register.twig');
    }
    
    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function doRegister(): Response | RedirectResponse
    {
        try {
            return $this->handleForm(
                validateForm: function () {
                    $postData = $this->requestService->getBody('email', 'password', 'firstName', 'lastName');

                    if (count(array_diff(['email', 'password', 'firstName', 'lastName'], array_keys($postData)))) {
                        throw new \Exception('Invalid form', code: 404);
                    } else {
                        return new User(...['id' => null, ...$postData]);
                    }
                },
                onSuccess: function ($user) {
                    $this->userRepository->save($user);
                    //envoi de mail d'inscription ?

                    return $this->redirect('/phpblog/');
                },
            );
        } catch (\Exception $e) {
            return $this->render('error.twig', args: ['message' => $e->getMessage()], statusCode: $e->getCode());
        }
    }
}