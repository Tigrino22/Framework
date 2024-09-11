<?php

use Dotenv\Dotenv;

define("BASE_PATH", dirname(__DIR__));

$dotenv = Dotenv::createUnsafeImmutable(BASE_PATH);
$dotenv->load();
