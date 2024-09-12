<?php

/**
 * Fichier de configuration et d'initialisation.
 * Déclaration des constantes et initialisation des paramètres.
 */

use Dotenv\Dotenv;
use Tigrino\Core\Errors\ErrorHandler;

// Initialisation et exécution de la logique
(function () {
    // Déclaration des constantes
    define("BASE_PATH", dirname(__DIR__));
    define("CONFIG_DIR", __DIR__);

    // Chargement des variables d'environnement
    $dotenv = Dotenv::createUnsafeImmutable(BASE_PATH);
    $dotenv->load();

    // Enregistrement du ErrorHandler pour la capture des erreurs
    $errorHandler = new ErrorHandler();
    $errorHandler->register();
})();
