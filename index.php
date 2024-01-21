<?php

require_once 'vendor/autoload.php';

use App\Controller\TestController;
use App\Router;
use Dotenv\Dotenv;

//Initialisation du fichier d'environnement
$dotEnv = Dotenv::createImmutable(__DIR__, ['.env', '.env.local']);
$dotEnv->load();

// Configuration des routes
$router = new Router();

// Initiliaser les routes dans notre Router
$router->add('home', TestController::class, 'home');
$router->add('list', TestController::class, 'list');
$router->add('post', TestController::class, 'postQqch', 'POST');


$router->run();