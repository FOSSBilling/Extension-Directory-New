<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

define('BASE_PATH', __DIR__);
require_once BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Bootstrap.php';

// Setup Symfony Dependency Injection Container
$container = new ContainerBuilder();
$loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/Config'));
$loader->load('services.php');
$container->compile();

// Create Slim app with Symfony container
AppFactory::setContainer($container);
$app = AppFactory::create();

// If cache is enabled, enable the router cache
if ($_ENV["CACHE_ENABLED"] === 'true') {
    $routeCollector = $app->getRouteCollector();
    $routeCollector->setCacheFile(PATH_CACHE . DIRECTORY_SEPARATOR . 'Routes.cache');
}

$twig = Twig::create(BASE_PATH . DIRECTORY_SEPARATOR . 'Templates', [
    'cache' => $_ENV["CACHE_ENABLED"] === 'true' ? PATH_CACHE : false,
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Register custom filters
$twig->addExtension($container->get(\ExtensionDirectory\TwigFilters::class));
$twig->addExtension(new Marek\Twig\ByteUnitsExtension());

$app->add(TwigMiddleware::create($app, $twig));

// Require the routes file and pass the $app instance to it
$routes = require BASE_PATH . DIRECTORY_SEPARATOR . 'App' . DIRECTORY_SEPARATOR . 'Routes.php';
$routes($app);

// Finally, run the app and let Slim handle the routing
$app->run();
