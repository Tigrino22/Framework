<?php

namespace Tigrino\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\Relay;
use Tigrino\Core\Auth\Middleware\RoleMiddleware;
use Tigrino\Core\Modules\ModuleInterface;
use Tigrino\Core\Router\Router;
use Tigrino\Core\Router\RouterInterface;

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
     * Middlewares de l'application
     *
     *  @var MiddlewareInterface[]
     */
    private $middlewares = [];

    /**
     * Modules a charger du programme
     *
     *  @var ModuleInterface[]
     */
    private $modules = [];


    /**
     * __construct
     * Prends en paramètre un tableau de routes via un fichier de configuration
     *
     * @param  array routes
     *
     * @return void
     */
    public function __construct(array $routes, array $modules = [])
    {
        $this->router = new Router();
        $this->router->addRoutes($routes);

        foreach ($modules as $module) {
            (new $module())($this);
        }
    }

    /**
     * Fonction ajoutant des middlewares a l'application
     *
     *  @param MiddlewareInterface[]|MiddlewareInterface
     */
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

        // Middleware de protection des routes
        $this->addMiddleware(new RoleMiddleware($this->router->getProtectedRoutes(), $this->router));

        // Last middleware pour géré le routing
        $this->addMiddleware(function ($request, $handler) {
            $response = $this->router->dispatch($request);

            return $response;
        });

        // Execution de la pile de middleware.
        $relay = new Relay($this->middlewares);

        return $relay->handle($request);
    }

    /**
     *
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
