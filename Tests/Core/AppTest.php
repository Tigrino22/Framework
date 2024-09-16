<?php

namespace Tests\Core;

use Dotenv\Dotenv;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tigrino\Core\App;
use Tigrino\Core\Middleware\TrailingSlashMiddleware;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $dotenv = Dotenv::createUnsafeImmutable(dirname(dirname(__DIR__)));
        $dotenv->load();

        $request = new ServerRequest("GET", "/azeaze/");
        define("CONFIG_DIR", dirname(dirname(__DIR__)) . "/Config");
        $app = new App([]);

        // Ajouter le middleware du trailing slash
        $app->addMiddleware(new TrailingSlashMiddleware());

        $response = $app->run($request);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals("/azeaze", $response->getHeaderLine("Location"));
    }
}
