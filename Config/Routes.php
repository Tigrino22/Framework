<?php

use Tigrino\Api\Blog\Controllers\BlogController;

return [
    [ "GET", "/blog", [BlogController::class, "index"], "blog" ],
    [ "GET", "/blog/show-[i:id]", [BlogController::class, "show"], "blog.show" ],
];
