<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

define('BASE_PATH', __DIR__);
define('PATH_CACHE', __DIR__ . DIRECTORY_SEPARATOR . 'Cache');

// Setup and load both autoloaders
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$loader = require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Autoloader.php';
$loader->register(true);

// Setup Dependency Injection
$container = new Container();
$container->set('cache', function () {
    return new FilesystemAdapter('fs_cache', 3600, PATH_CACHE);
});

// Now create the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$twig = Twig::create(BASE_PATH . DIRECTORY_SEPARATOR . 'Templates', [
    'cache' => PATH_CACHE,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$app->add(TwigMiddleware::create($app, $twig));

// Require the routes file and pass the $app instance to it
$routes = require BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'routes.php';
$routes($app);

// Finally, run the app and let Slim handle the routing
$app->run();
