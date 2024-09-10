<?php

namespace Test\Core;

use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tigrino\Core\App;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $request = new ServerRequest("GET", "/azeaze/");
        $app = new App([]);
        /** @var ResponseInterface */
        $response = $app->run($request);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals("/azeaze", $response->getHeaderLine("Location"));
    }
}
