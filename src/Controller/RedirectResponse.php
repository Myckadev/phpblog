<?php

namespace App\Controller;

class RedirectResponse
{

    protected string $uri;
    protected int $statusCode;

    public function __construct($uri = '', $statusCode = 302)
    {
        $this->uri = $uri;
        $this->statusCode = $statusCode;
        $this->redirect();
    }

    public function redirect(): void
    {
        header('Location: ' . $this->uri, true, $this->statusCode);
    }
}