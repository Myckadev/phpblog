<?php

namespace App\Controller;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected Environment $twig;

    public function __construct()
    {
        $this->twig = $this->initializeTwig();
    }

    abstract protected function initializeRepository();

    private function initializeTwig(): Environment
    {
        $twigLoader = new FilesystemLoader(__DIR__ . '/../Template');
        return new Environment($twigLoader, [
            'cache' => __DIR__ . '/../../cache',
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
        return new Response($this->twig->render($template, $args), $statusCode);
    }

    protected function redirect(string $uri): RedirectResponse
    {
        return new RedirectResponse($uri);
    }
}
