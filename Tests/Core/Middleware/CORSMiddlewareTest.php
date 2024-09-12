<?php

namespace Tests\Core\Middleware;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tigrino\Core\Middleware\CorsMiddleware;
use Tigrino\Http\Response\JsonResponse;

class CorsMiddlewareTest extends TestCase
{
    private CorsMiddleware $middleware;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new CorsMiddleware([
            'allowed_origins' => ['*'],
            'allowed_methods' => ['GET', 'POST', 'OPTIONS'],
            'allowed_headers' => ['Content-Type', 'Authorization'],
            'exposed_headers' => ['X-Custom-Header'],
            'max_age' => 3600,
            'allow_credentials' => true,
        ]);
    }

    public function testHandlePreflightRequest()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getMethod')->willReturn('OPTIONS');
        $request->method('getHeaderLine')->willReturn('*');

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn(new JsonResponse());

        $response = $this->middleware->process($request, $handler);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('*', $response->getHeaderLine('Access-Control-Allow-Origin'));
        $this->assertEquals('GET, POST, OPTIONS', $response->getHeaderLine('Access-Control-Allow-Methods'));
        $this->assertEquals('Content-Type, Authorization', $response->getHeaderLine('Access-Control-Allow-Headers'));
        $this->assertEquals('3600', $response->getHeaderLine('Access-Control-Max-Age'));
    }

    public function testHandleRequest()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getMethod')->willReturn('GET');
        $request->method('getHeaderLine')->willReturn('*');

        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn(new JsonResponse());

        $response = $this->middleware->process($request, $handler);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('*', $response->getHeaderLine('Access-Control-Allow-Origin'));
    }
}
