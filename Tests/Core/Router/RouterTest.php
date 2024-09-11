<?php

namespace Tests\Core\Router;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tigrino\Core\Router\Router;
use Tests\Core\Controllers\TestController;
use Tigrino\Core\App;

class RouterTest extends TestCase
{
    /** @var Router */
    private $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetRouteMatched()
    {
        // Définir une route GET simple
        $routes = [
            ["GET", "/test", [TestController::class, "index"], "test.show", []]
        ];

        $this->router->addRoutes($routes);

        // Simuler une requête GET sur /test
        $request = new ServerRequest('GET', '/test');

        // Dispatcher la requête et obtenir la réponse
        $response = $this->router->dispatch($request);

        // Vérifier que la réponse est correcte
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Hello test", (string)$response->getBody());
    }

    public function testGetRouteMatchedWithCallable()
    {
        // Définir une route GET simple
        $routes = [
            ["GET", "/test", function () {
                return new Response(200, [], "Hello test callable");
            }, "test.show", []]
        ];

        $this->router->addRoutes($routes);

        // Simuler une requête GET sur /test
        $request = new ServerRequest('GET', '/test');

        // Dispatcher la requête et obtenir la réponse
        $response = $this->router->dispatch($request);

        // Vérifier que la réponse est correcte
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Hello test callable", (string)$response->getBody());
    }

    public function testPostRouteNotFound()
    {
        // Définir une route GET mais tester une requête POST
        $routes = [
            ["GET", "/test", [TestController::class, "index"], "test.show", []]
        ];

        $this->router->addRoutes($routes);

        // Simuler une requête POST sur /test
        $request = new ServerRequest('POST', '/test');

        // Dispatcher la requête et obtenir la réponse
        $response = $this->router->dispatch($request);

        // Vérifier qu'une erreur 404 est renvoyée
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("<h1>Page not found</h1>", (string)$response->getBody());
    }

    public function testRouteWithParameter()
    {
        // Définir une route avec un paramètre {id}
        $routes = [
            ["GET", "/test/[i:id]-[a:slug]", [TestController::class, "show"], "test.showWithId", []]
        ];

        $this->router->addRoutes($routes);

        // Simuler une requête GET sur /test/123
        $request = new ServerRequest('GET', '/test/123-Tigrino');

        // Dispatcher la requête et obtenir la réponse
        $response = $this->router->dispatch($request);

        // Vérifier que la réponse est correcte
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Hello test 123-Tigrino", (string)$response->getBody());
    }


    public function testRouteNotFound()
    {
        // Aucune route n'est ajoutée
        $request = new ServerRequest('GET', '/non-existent');

        // Dispatcher la requête et obtenir la réponse
        $response = $this->router->dispatch($request);

        // Vérifier qu'une erreur 404 est renvoyée
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals("<h1>Page not found</h1>", (string)$response->getBody());
    }

    public function testProtectedRouteAccess()
    {
        // Définir une route protégée
        $routes = [
            ["GET", "/admin", [TestController::class, "admin"], "admin.dashboard", ["admin"]]
        ];

        $app = new App($routes);

        // Simuler une requête avec un rôle insuffisant
        $request = new ServerRequest('GET', '/admin');
        $request = $request->withAttribute('user_role', 'user'); // Rôle insuffisant

        // Dispatcher la requête et obtenir la réponse
        $response = $app->run($request);

        // Vérifier que l'accès est refusé
        $this->assertEquals(403, $response->getStatusCode());
        $this->assertEquals("<h1>Accès interdit</h1>", (string)$response->getBody());
    }

    public function testAccessGrantedForProtectedRoute()
    {
        // Définir une route protégée
        $routes = [
            ["GET", "/admin", [TestController::class, "admin"], "admin.dashboard", ["admin"]]
        ];

        $this->router->addRoutes($routes);

        // Simuler une requête avec un rôle suffisant
        $request = new ServerRequest('GET', '/admin');
        $request = $request->withAttribute('user_role', 'admin'); // Rôle suffisant

        // Dispatcher la requête et obtenir la réponse
        $response = $this->router->dispatch($request);

        // Vérifier que la réponse est correcte
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals("Hello admin", (string)$response->getBody()); // Modifier selon la réponse attendue
    }
}
