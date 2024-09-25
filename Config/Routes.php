<?php

/**
 * Fichier de configuration des routes.
 * Voir Altorouter pour la configuration des paramètres.
 * [method, path, target = [array[Controller, method]]|Callabale, name = "", rôle = ""]
 *
 */

use Tigrino\Api\Blog\Controllers\ExampleController;

return [
    ["GET", "/",    [ExampleController::class,  "index"],   "blog", ["user"]],
];
