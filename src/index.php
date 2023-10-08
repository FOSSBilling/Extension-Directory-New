<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Dotenv\Dotenv;

define('BASE_PATH', __DIR__);
define('PATH_CACHE', __DIR__ . DIRECTORY_SEPARATOR . 'Cache');

// Load the composer autoloader
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Load the .env file
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . DIRECTORY_SEPARATOR . '.env');
if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . '.env.local')) {
    $dotenv->overload(__DIR__ . DIRECTORY_SEPARATOR .  '.env.local');
}

// Now register the AntLoader autoloader
$loader = require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Autoloader.php';
$loader->register(true);

// Setup Dependency Injection
$container = new Container();
$container->set('cache', function () {
    // FilesystemAdapter is used when cache is enabled to ensure persistance, otherwise ArrayAdapter.
    if ($_ENV["CACHE_ENABLED"] === 'true') {
        return new FilesystemAdapter('fs_cache', 3600, PATH_CACHE);
    } else {
        return new ArrayAdapter();
    }
});

// Now create the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$twig = Twig::create(BASE_PATH . DIRECTORY_SEPARATOR . 'Templates', [
    'cache' => $_ENV["CACHE_ENABLED"] === 'true' ? PATH_CACHE : false,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$app->add(TwigMiddleware::create($app, $twig));

// Require the routes file and pass the $app instance to it
$routes = require BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Routes.php';
$routes($app);

// Finally, run the app and let Slim handle the routing
$app->run();
