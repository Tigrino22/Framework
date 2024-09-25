<?php

/**
 * L'injection des modules ici se fait par nom de dossier.
 */

use Tigrino\Auth\AuthModule;
use Tigrino\Attaque\AttaqueModule;

return [
    AttaqueModule::class,
    AuthModule::class,
];
