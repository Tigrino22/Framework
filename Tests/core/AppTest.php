<?php

namespace Test\Core;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tigrino\Core\App;
use Tigrino\Core\Middleware\TrailingSlashMiddleware;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $request = new ServerRequest("GET", "/azeaze/");
        $app = new App([]);

        // Ajouter le middleware du trailing slash
        $app->addMiddleware(new TrailingSlashMiddleware());

        /** @var ResponseInterface */
        $response = $app->run($request);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals("/azeaze", $response->getHeaderLine("Location"));
    }
}
