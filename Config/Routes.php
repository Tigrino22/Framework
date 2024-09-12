<?php

/**
 * Fichier de configuration des routes.
 * Voir Altorouter pour la configuration des paramètres.
 * [method, path, target = [array[Controller, method]]|Callabale, name = "", rôle = ""]
 *
 */

use Tigrino\Api\Blog\Controllers\ExampleController;

return [
    ["POST",     "/blog/create",            [ExampleController::class, "create"],  "blog.create",  []],
    ["POST",     "/",                       [ExampleController::class, "getInfo"], "blog.post",    []],
    ["GET",     "/blog/name-[a:name]",      [ExampleController::class, "admin"],   "blog.admin",   ["admin"]],
    ["GET",     "/blog/show-[i:id]",        [ExampleController::class, "show"],    "blog.show",    []],
    ["GET",     "/",                        [ExampleController::class, "index"],   "blog",         []],
];
