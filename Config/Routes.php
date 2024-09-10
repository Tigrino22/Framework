<?php

/**
 * Fichier de configuration des routes.
 * Voir Altorouter pour la configuration des paramètres.
 * [method, path, target = [array[Controller, method]]|Callabale, name = "", rôle = ""]
 *
 */

use Tigrino\Api\Blog\Controllers\BlogController;

return [
    ["GET",     "/blog/name-[a:name]",   [BlogController::class, "admin"],   "blog.admin",   ["admin"]],
    ["GET",     "/blog/show-[i:id]",    [BlogController::class, "show"],    "blog.show",    []],
    ["GET",     "/",                    [BlogController::class, "index"],   "blog",         []],
];
