<?php

namespace Tigrino\Auth\Controller;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Tigrino\Core\Controller\AbstractController;
use Tigrino\Http\Response\JsonResponse;

class AuthController extends AbstractController
{
    public function register(): ResponseInterface
    {

        if ($this->request->getMethod() === "POST") {
            return new JsonResponse(
                status: 200,
                headers: [],
                data: [
                    "message" => "Route Register en method POST"
                ]
            );
        }
        return new Response(
            status: 200,
            headers: [],
            body: "<h1>Page Register GET Method</h1>"
        );
    }
}
