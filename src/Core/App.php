<?php

namespace Tigrino\Core;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tigrino\Core\Router\Router;

/**
 * App
 */
class App
{
    /**
     * routerFactory
     *
     * @var Router
     */
    private $router;


    /**
     * __construct
     * Prends en paramètre un tableau de routes via un fichier de configuration
     *
     * @param  array routes
     *
     * @return void
     */
    public function __construct(array $routes)
    {
        $this->router = new Router();
        $this->router->addRoutes($routes);
    }

    /**
     * run
     *
     * @param ServerRequestInterface
     * @return ResponseInterface
     */
    public function run(ServerRequest $request): ResponseInterface
    {

        // Récupère l'URI et la méthode de la requête
        $uri = $request->getUri();
        $method = $request->getMethod();

        if (!empty($uri) && substr($uri, -1) === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", substr($uri, 0, -1));
        }

        // Logique pour dispatcher la requête et obtenir une réponse
        return $this->router->dispatch($request);
    }
}
