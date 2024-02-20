<?php
use Symfony\Component\Dotenv\Dotenv;

function env($key) {
    $dotenv = new Dotenv();
    $dotenv->loadEnv(__DIR__ . '/../.env');

    return $_ENV[$key];
    unset($dotenv);
}
