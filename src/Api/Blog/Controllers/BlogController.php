<?php

namespace Tigrino\Api\Blog\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class BlogController
{
    public function index(): ResponseInterface
    {
        return new Response(200, [], "<h1>Fonction index du controller Blog</h1>");
    }

    public function show(int $id): ResponseInterface
    {
        return new Response(200, [], "<h1>Article avec id : {$id}</h1>");
    }

    /**
     * Route protéger par le role admin.
     * Retourne en json le nom passé en argument
     * /blog/name-{$name}
     *
     *  @return ResponseInterface
     */
    public function admin(string $name): ResponseInterface
    {
        $arguments = [
            "name" => $name
        ];

        return new Response(200, [], json_encode($arguments));
    }
}
