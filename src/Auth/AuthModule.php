<?php

namespace Tigrino\Auth;

use Tigrino\Core\App;
use Tigrino\Core\Modules\ModuleInterface;

class AuthModule implements ModuleInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * Méthode a implémenter en fonction du fonctionnement
     * du AuthModule.
     *
     * @param App $app
     * @return void
     */
    public function __invoke(App &$app): void
    {
        $this->app = $app;
        $this->app->getRouter()->addRoutes(include __DIR__ . "/Config/Routes.php");
    }
}
