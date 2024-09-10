<?php

namespace Tigrino\Core;

interface ModuleInterface
{
    /**
     * L'implémentation de cette fonction dans les modules est
     * nécessaire afin d'initialiser le module en question.
     *
     */
    public function __invoke(App &$app);
}
