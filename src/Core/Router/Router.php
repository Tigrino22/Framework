<?php

namespace Tigrino\Core\Router;

use AltoRouter;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tigrino\Core\Router\Exception\ControllerException;

/**
 * Router based on Altorouter
 * https://packagist.org/packages/altorouter/altorouter
 *
 * POur ajouter des routes:
 * Dans le ./Config/Routes.php
 *
 * ex:
 *  return [
 *          [ "GET", "/blog", [BlogController::class, "index"], "blog.show" ],
 *          [ "GET", "/blog/show-[i:id]", [BlogController::class, "show"], "blog.show" ],
 *      ];
 *
 * Pour les paramètrs, voir le lien suivant :
 * https://dannyvankooten.github.io/AltoRouter/usage/mapping-routes.html
 *
 */
class Router implements RouterInterface
{
    /**
     * router
     *
     * @var Altorouter
     */
    private $router = null;

    /**
     * Initialise l'instance d'AltoRouter lors de la création du Router.
     */
    public function __construct()
    {
        $this->router = new AltoRouter();
    }

    /**
     * Méthode pour ajouter les routes au router franchaiment initialisé.
     *
     * @param array $routes
     * @return void
     */
    public function addRoutes(array $routes): void
    {
        foreach ($routes as $route) {
            [$method, $path, $callback, $name] = [...$route];
            $this->router->map($method, $path, $callback, $name);
        }
    }

    /**
     * Match a given Request Url against stored routes
     * @param string $requestUrl
     * @param string $requestMethod
     * @return ?array Array with route information on success, false on failure (no match).
     */
    public function match(string $requestMethod, string $requestUri): ?array
    {
        // Extraire seulement le chemin de l'URL
        $path = parse_url($requestUri, PHP_URL_PATH);
        $match = $this->router->match($path, $requestMethod);

        return $match ?: null;
    }

    /**
     * Après le match, méthode qui va chercher le callback afin de l'appeler.
     *
     * @param RequestInterface
     * @return ResponseInterface
     */
    public function dispatch(RequestInterface $request): ResponseInterface
    {
        $route = $this->match($request->getMethod(), (string) $request->getUri());

        if ($route) {
            [$controller, $method] = $route['target'];
            $params = $route['params']; // Extraire les paramètres

            if (class_exists($controller) && method_exists($controller, $method)) {
                // Appeler la méthode du contrôleur avec les paramètres extraits
                return call_user_func_array([new $controller(), $method], $params);
            } else {
                throw new ControllerException("Le controller {$controller} n'est pas trouvable.
                    Ou la méthode {$method} n'est pas correcte.");
            }
        } else {
            return new Response(404, [], "<h1>Page not found</h1>");
        }
    }


    /**
     * Generate the URL for a named route. Replace regexes with supplied parameters
     *
     * @param string $routeName The name of the route.
     * @param array @params Associative array of parameters to replace placeholders with.
     * @return string The URL of the route with named parameters in place.
     */
    public function generate($routeName, array $params = []): string
    {
        return $this->router->generate($routeName, $params);
    }
}
