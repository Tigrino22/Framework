<?php

use Tigrino\Auth\Controller\AuthController;

return [
    ["GET", "/register", [AuthController::class, "register"], "auth.register.get", []],
    ["POST", "/register", [AuthController::class, "register"], "auth.register.post", []],
];
