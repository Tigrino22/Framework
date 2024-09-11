<?php

/**
 * Fichier nettoyant les logs.
 * Il sera important de le protéger avec que les
 * logs ne soient pas supprimer par inadvertence
 * ou part vandalisme.
 *
 */

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Core/Misc/utils.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

if (getenv("APP_ENV") === "DEV") {
    try {
        file_put_contents(dirname(__DIR__) . "/Logs/errors.log", "");
        colorLog("Les logs ont bien été nettoyés.\n", "s");
    } catch (\Exception $e) {
        colorLog("Une Erreur est survenue pendant le nettoyage des logs : {$e->getMessage()}\n", "e");
    }
} else {
    colorLog("La suppression des logs n'est possible qu'en environnement de développement.\n", "e");
}
