<?php

use Twig\Environment as TwigEnvironment;

class Router 
{
    private TwigEnvironment $twig;
    private $routes = [];

    public function __construct(TwigEnvironment $twig)
    {
        $this->twig = $twig;
    }


    public function add($uri, $controller, $method, $httpMethod = 'GET'): static
    {
        $uriPattern = preg_replace('/{([^\/]+)}/', '([^\/]+)', $uri);
        $this->routes[] = ['uriPattern' => $uriPattern, 'controller' => $controller, 'method' => $method, 'httpMethod' => $httpMethod];

        return $this;
    }

    public function run(): void
    {
        //TODO: retirer le prefix à la con
        $uri = str_replace('/phpblog/', '', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "phpblog"));
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if (preg_match("@^" . $route['uriPattern'] . "$@", $uri, $matches) && $requestMethod == $route['httpMethod']) {
                array_shift($matches); // Retirer le chemin complet
    
                // Préfixez le nom du contrôleur avec le namespace
                $controllerName = $route['controller'];
                if(class_exists($controllerName)) {
                    $controller = new $controllerName($this->twig);
                    if(method_exists($controller, $route['method'])) {
                        call_user_func_array([$controller, $route['method']], $matches);
                    } else {
                        // Gestion d'erreur si la méthode n'existe pas
                        header("HTTP/1.1 404 Not Found");
                        echo "404 Not Found - Method not found";
                    }
                } else {
                    // Gestion d'erreur si la classe n'existe pas
                    header("HTTP/1.1 404 Not Found");
                    echo "404 Not Found - Controller class not found";
                }
                return;
            }
        }
    
        header("HTTP/1.1 404 Not Found");
        echo "404 Not Found";
    }

}
