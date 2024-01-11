<?php

require_once 'vendor/autoload.php';
require 'Router.php';

use App\Controller\TestController;
use Twig\Loader\FilesystemLoader as TwigFileLoader;
use Twig\Environment as TwigEnvironment;

// Configuration de Twig
$twigLoader = new TwigFileLoader(__DIR__ . '/src/Template');
$twig = new TwigEnvironment($twigLoader, [
    'cache' => __DIR__ . '/cache',
    'debug' => true, //retirer pour la prod
]);

// Configuration des routes
$router = new Router(twig: $twig);

// Supposons que vos contrôleurs sont dans le namespace App\Controller
$router->add('home', TestController::class, 'home', 'GET');
$router->add('list', TestController::class, 'list', 'GET'); 

$router->run();