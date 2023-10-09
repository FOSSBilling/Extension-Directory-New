<?php

use Symfony\Component\Dotenv\Dotenv;

define('PATH_CACHE', BASE_PATH . DIRECTORY_SEPARATOR . 'Cache');

// Load the composer autoloader
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$dotenv = new Dotenv();
$dotenv->load(BASE_PATH . DIRECTORY_SEPARATOR . '.env');
if (file_exists(BASE_PATH . DIRECTORY_SEPARATOR . '.env.local')) {
    $dotenv->overload(BASE_PATH . DIRECTORY_SEPARATOR .  '.env.local');
}

// Now register the AntLoader autoloader
$loader = require_once __DIR__ . DIRECTORY_SEPARATOR . 'Autoloader.php';
$loader->register(true);
