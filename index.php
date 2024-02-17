<?php

require_once 'vendor/autoload.php';

use App\Controller\ArticleController;
use App\Controller\HomeController;
use App\Controller\SecurityController;
use App\Router;

// Configuration des routes
$router = new Router();

// Initiliaser les routes dans notre Router
$router->add('', HomeController::class, 'home');
$router->add('auth_login', SecurityController::class, 'doLogin', 'POST');
$router->add('login', SecurityController::class, 'login');
$router->add('logout', SecurityController::class, 'logout');
$router->add('register', SecurityController::class, 'register',);
$router->add('auth_register', SecurityController::class, 'doRegister', 'POST');
$router->add('articles', ArticleController::class, 'getArticles');
$router->add('articles/{id}', ArticleController::class, 'getArticleDetails');
$router->add('articles/create', ArticleController::class, 'postArticle', 'POST');

$router->run();