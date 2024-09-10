<?php

namespace Tests\Core\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class TestController
{
    public function index(): ResponseInterface
    {
        return new Response(200, [], "Hello test");
    }

    public function show(int $id, string $slug): ResponseInterface
    {
        return new Response(200, [], "Hello test {$id}-{$slug}");
    }
}
