<?php

namespace Tigrino\Core\Auth;

use Tigrino\Core\App;
use Tigrino\Core\Modules\ModuleInterface;

class AuthModule implements ModuleInterface
{
    /**
     * @var App
     */
    private $app;

    public function __invoke(App &$app)
    {
        $this->app = $app;
    }
}
