<?php

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ExtensionDirectory\ResponseHelper;
use ExtensionDirectory\BadgeBuilder;

define('BASE_PATH', __DIR__);
define('PATH_CACHE', __DIR__ . DIRECTORY_SEPARATOR . 'Cache');

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Setup the auto-loader
$loader = new AntCMS\AntLoader(['path' => PATH_CACHE . DIRECTORY_SEPARATOR . 'Classmap.php', 'mode' => 'filesystem']);
$loader->addNamespace('', BASE_PATH . DIRECTORY_SEPARATOR . 'Components');
$loader->addNamespace('', BASE_PATH . DIRECTORY_SEPARATOR . 'Library');
$loader->checkClassMap();
$loader->register(true);

// Setup Dependency Injection
$container = new Container();
$container->set('cache', function () {
    return new FilesystemAdapter('fs_cache', 3600, PATH_CACHE);
});

// Now create the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$twig = Twig::create(BASE_PATH . DIRECTORY_SEPARATOR . 'Templates', ['cache' => PATH_CACHE, 'debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function (Request $request, Response $response, $args) {
    $extensionList = ExtensionDirectory\ExtensionInfo::getAllExtensions(true, $this->get('cache'));
    if (!$extensionList) {
        // TODO: Handle errors here
    } else {
        return ResponseHelper::renderTwigTemplate($response, $request, 'index.html.twig', ['extensions' => $extensionList]);
    }
})->setName('index');


$app->get('/extension/{id}', function (Request $request, Response $response, $args) {
    $extensionInfo = ExtensionDirectory\ExtensionInfo::getExtensionInfo($args['id'], true, $this->get('cache'));
    if (!$extensionInfo) {
        // TODO: Handle errors here
    } else {
        return ResponseHelper::renderTwigTemplate($response, $request, 'extensionInfo.html.twig', ['extension' => $extensionInfo]);
    }
})->setName('extension');

$app->get('/api/extension/{id}', function (Request $request, Response $response, $args) {
    $extensionInfo = ExtensionDirectory\ExtensionInfo::getExtensionInfo($args['id'], false, $this->get('cache'));
    if (!$extensionInfo) {
        // TODO: Handle errors here
    } else {
        return ResponseHelper::renderJson(false, $extensionInfo, $response);
    }
});

$app->any('/api/list', function (Request $request, Response $response, $args) {
    $extensionList = ExtensionDirectory\ExtensionInfo::getAllExtensions(false, $this->get('cache'));
    $GET = $request->getQueryParams();
    $POST = $request->getParsedBody();
    $filterType = $GET['type'] ?? $POST['type'] ?? null;

    // Filter the type if needed
    if (!empty($filterType)) {
        $extensionList = array_filter($extensionList, function ($extension) use ($filterType) {
            return $extension['type'] == $filterType;
        }, ARRAY_FILTER_USE_BOTH);
    }

    if (!$extensionList) {
        // TODO: Handle errors here
    } else {
        return ResponseHelper::renderJson(false, $extensionList, $response);
    }
});

$app->get('/api/extension/{id}/badges/{type}', function (Request $request, Response $response, $args) {
    $badge = BadgeBuilder::buildABadge($args['id'], $args['type'], $this->get('cache'));
    $response->getBody()->write($badge);
    return $response;
});

$app->run();
