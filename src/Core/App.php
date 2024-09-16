<?php

namespace Tigrino\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Relay\Relay;
use Tigrino\Auth\Middleware\AuthMiddleware;
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
     * Prends en paramètre un tableau de modules via un fichier de configuration
     *
     * @param array $modules
     *
     * @return void
     */
    public function __construct(array $modules = [])
    {
        $this->router = new Router();

        // Ajout des routes générales.
        $this->router->addRoutes(include(CONFIG_DIR . "/Routes.php"));

        /**
         * Initialisation de chaque module
         * en passant par la méthode __invocke?
         */
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
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        // Middleware de protection des routes
        $this->addMiddleware(new AuthMiddleware($this->router->getProtectedRoutes(), $this->router));

        // Last middleware pour géré le routing
        $this->addMiddleware(function ($request, $handler) {
            return $this->router->dispatch($request);
        });

        // Execution de la pile de middleware.
        $relay = new Relay($this->middlewares);

        return $relay->handle($request);
    }

    /**
     * Getter nécessaire pour que chaque module
     * initialise ses propres routes.
     *
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
