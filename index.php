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

// Supposons que vos contrôleurs sont dans le namespace App\Controller
$router->add('home', TestController::class, 'home', 'GET');
$router->add('list', TestController::class, 'list', 'GET'); 

$router->run();