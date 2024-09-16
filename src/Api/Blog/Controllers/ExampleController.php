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
            "message" => $this->request->getServerParams()
        ];
        return new JsonResponse(data: $data);
    }

    public function getInfo(): ResponseInterface
    {
        $data = $this->request->getAttributes();
        return new JsonResponse(data: $data);
    }

    public function show(int $id): ResponseInterface
    {
        return new Response(200, [], "<h1>Article avec id : {$id}</h1>");
    }

    public function admin(string $name): ResponseInterface
    {
        $arguments = [
        "name" => $name,
            "message" => "Bravo, tu as atteind la route!"
        ];

        return new JsonResponse(
            200,
            [],
            $arguments
        );
    }

    public function create(): ResponseInterface
    {
        // Récupérer les données brutes POST
        $body = $this->request->getBody()->getContents();

        // Décode le JSON si nécessaire
        $data = json_decode($body, true);

        // Vérifie les données reçues
        $dataReceived = $data ?: 'Aucune donnée reçue';

        // Traitement des données (ex. : enregistrement dans une base de données)
        // Ici, nous renvoyons simplement les données reçues pour démonstration
        return new JsonResponse(data: [
            "message" => "Données reçues avec succès",
            "Donnees" => $dataReceived
        ]);
    }
}
