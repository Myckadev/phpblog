<?php

namespace App\Controller;

use App\Service\RequestService;
use App\Service\SessionService;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected Environment $twig;
    protected SessionService $sessionService;
    protected RequestService $requestService;

    public function __construct()
    {
        $this->twig = $this->initializeTwig();
        $this->sessionService = new SessionService();
        $this->requestService = new RequestService();
    }

    abstract protected function initializeRepository();

    // Twig nous permet de prendre en charge l'escape de caractère spéciaux ce qui évite les failles XSS (Cross-Site Scripting)
    private function initializeTwig(): Environment
    {
        $twigLoader = new FilesystemLoader(__DIR__.'/../Template');
        return new Environment($twigLoader, [
            'cache' => __DIR__.'/../../cache',
            'debug' => true, //retirer pour la prod
        ]);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    protected function render($template, array $args = [], $statusCode = 200): Response
    {
        return new Response($this->twig->render($template, $args), statusCode: (int)$statusCode);
    }

    protected function redirect(string $uri): RedirectResponse
    {
        return new RedirectResponse($uri);
    }

    /**
     * @param callable $validateForm   This function is used to give to our handleForm method how to validate data
     * @param callable $onSuccess      This function is used to give to our handleForm what he must do with the validate result (do some check or whatever)
     * @param string|null $csrfToken   This params is used to check csrf token on form if we choose to use it (In login case, he must be not set)
     *
     *
     * @throws \Exception
     */
    protected function handleForm(callable $validateForm, callable $onSuccess, ?string $csrfToken = null)
    {
        if ($csrfToken && !$this->sessionService->isCsrfTokenValid($csrfToken)) {
            throw new \Exception('Invalid CSRF TOKEN', 403);
        }

        if ($result = $validateForm()) {
            return $onSuccess($result);
        }

        return throw new \Exception('Invalid Form', 404);

    }
}
