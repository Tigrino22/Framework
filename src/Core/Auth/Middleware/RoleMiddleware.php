<?php

namespace Tigrino\Core\Auth\Middleware;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tigrino\Core\Router\RouterInterface;

class RoleMiddleware implements MiddlewareInterface
{
    private $protectedRoutes = [];
    private $router;

    public function __construct(array $protectedRoutes, RouterInterface $router)
    {
        $this->protectedRoutes = $protectedRoutes;
        $this->router = $router;
    }

    /**
     *
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        // Obtenir le chemin et la méthode HTTP
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();
        $userRole = $request->getAttribute('user_role');

        // Match pour trouver une route qui correspond a la requête
        $match = $this->router->match($method, $path);

        // Si une route est trouvée
        if ($match) {
            // Vérifier si cette route est protégée
            foreach ($this->protectedRoutes as $protectedRoute) {
                if ($match['name'] === $protectedRoute['name']) {
                    $requiredRoles = $protectedRoute['role'];

                    // Vérifier si l'utilisateur a les rôles requis
                    if (count($requiredRoles) > 0 && !in_array($userRole, $requiredRoles)) {
                        return new Response(403, [], "<h1>Accès interdit</h1>");
                    }
                }
            }
        }

        return $handler->handle($request);
    }
}
