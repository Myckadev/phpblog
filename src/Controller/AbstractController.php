<?php

namespace App\Controller;

use Twig\Environment as TwigEnvironment;

abstract class AbstractController
{

    public function __construct(
        protected readonly TwigEnvironment $twig,
    ) {
    }

    protected function render($template, array $args = [])
    {
        echo $this->twig->render($template, $args);
    }
}
