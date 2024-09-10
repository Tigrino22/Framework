<?php

namespace Tests\Core\Router;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tigrino\Core\Router\Router;
use Tests\Core\Controllers\TestController;

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
            ["GET", "/test", [TestController::class, "index"], "test.show"]
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

    public function testPostRouteNotFound()
    {
        // Définir une route GET mais tester une requête POST
        $routes = [
            ["GET", "/test", [TestController::class, "index"], "test.show"]
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
            ["GET", "/test/[i:id]-[a:slug]", [TestController::class, "show"], "test.showWithId"]
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
}
