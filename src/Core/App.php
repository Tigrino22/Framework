<?php

namespace Tigrino\Core;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;
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

    private $middlewares = [];


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


    public function addMiddleware($middlewares): void
    {
        if (is_array($middlewares)) {
            foreach ($middlewares as $middleware) {
                $this->middlewares[] = $middleware;
            }
        } else {
            $this->middlewares[] = $middlewares;
        }
    }

    /**
     * run
     *
     * @param ServerRequestInterface
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {

        // Last middleware pour géré le routing
        $this->addMiddleware(function ($request, $handler) {
            $response = $this->router->dispatch($request);

            return $response;
        });

        // Execution de la pile de middleware.
        $relay = new Relay($this->middlewares);

        return $relay->handle($request);
    }
}
