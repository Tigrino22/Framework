<?php

use GuzzleHttp\Psr7\ServerRequest;
use Tigrino\Core\App;

require "../vendor/autoload.php";

$app = new App();
$response = $app->run(ServerRequest::fromGlobals());
