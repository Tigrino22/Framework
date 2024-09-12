<?php

require "../vendor/autoload.php";
require_once __DIR__ . "/../Config/Config.php";

use GuzzleHttp\Psr7\ServerRequest;
use Tigrino\Core\App;
use Tigrino\Core\Middleware\WhoopsMiddleware;

use function Http\Response\send;

// import des modules depuis le fichiers de configuration Config/Modules.php
$middlewares = CONFIG_DIR . "/Middlewares.php";
$modules = CONFIG_DIR . "/Modules.php";

// Initialisation de l'app en passant le tableau de routes en paramètre.
$app = new App(include($modules));

// Mise en place de Whoops pour l'affiche-age des erreur
// en environnement de développement.
if (getenv("APP_ENV") === "DEV") {
    $app->addMiddleware(new WhoopsMiddleware());
}

$app->addMiddleware(include($middlewares));

$response = $app->run(ServerRequest::fromGlobals());

send($response);
