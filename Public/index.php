<?php

require_once __DIR__ . "/../Config/Config.php";

use GuzzleHttp\Psr7\ServerRequest;
use Tigrino\Core\App;

use function Http\Response\send;

require "../vendor/autoload.php";

$configDir = BASE_PATH . DIRECTORY_SEPARATOR . "Config" . DIRECTORY_SEPARATOR;

// import des modules depuis le fichiers de configuration Config/Modules.php
$routes = $configDir . "Routes.php";

// Initialisation de l'app en passant le tableau de routes en paramètre.
$app = new App(include($routes));
$response = $app->run(ServerRequest::fromGlobals());

send($response);
