<?php

namespace Tigrino\Core;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * App
 */
class App
{
    /**
     * modules
     *
     * @var array modules
     */
    private $modules = [];


    /**
     * __construct
     *
     * @param  array $modules
     *
     * @return void
     */
    public function __construct(array $modules = [])
    {
        foreach ($modules as $module) {
            $this->modules[] = $module;
        }
    }


    /**
     * run
     *
     * @return void
     */
    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri();
        if (!empty($uri) && substr($uri, -1) === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader("Location", substr($uri, 0, -1));
        }

        return new Response();
    }
}
