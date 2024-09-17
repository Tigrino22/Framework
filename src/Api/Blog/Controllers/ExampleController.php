<?php

namespace Tigrino\Api\Blog\Controllers;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Tigrino\Core\Controller\AbstractController;
use Tigrino\Http\Response\JsonResponse;

/**
 * Les controllers etendent de AbstractController
 * ce qui leur permet de récupérer la réquète.
 *  $this->request;
 */
class ExampleController extends AbstractController
{
    public function index(): ResponseInterface
    {
        $data = [
            "message" => "<h1>Bienvenue sur mon Framework</h1>\n<p>© Tigrino 2024, Licence MIT</p>"
        ];
        return new Response(
            200,
            [],
            $data["message"]
        );
    }
}
