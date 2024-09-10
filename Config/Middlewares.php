<?php

/**
 * Tableau où sont inscris tous les middlewares de l'application
 */

use Tigrino\Core\Middleware\TrailingSlashMiddleware;

return [
    new TrailingSlashMiddleware(),
];
