<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

define('BASE_PATH', __DIR__);
define('PATH_CACHE', __DIR__ . DIRECTORY_SEPARATOR . 'Cache');

require_once BASE_PATH . DIRECTORY_SEPARATOR . 'Vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Setup the auto-loader
$loader = new AntCMS\AntLoader();
$loader->addNamespace('', BASE_PATH . DIRECTORY_SEPARATOR . 'Components');
$loader->addNamespace('', BASE_PATH . DIRECTORY_SEPARATOR . 'Library');
$loader->checkClassMap();
$loader->register(true);

// Now create the app
//$app = \DI\Bridge\Slim\Bridge::create();
$app = AppFactory::create();
$twig = Twig::create(BASE_PATH . DIRECTORY_SEPARATOR . 'Templates', ['cache' => PATH_CACHE, 'debug' => true]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function (Request $request, Response $response, $args) {
    $extensions = ExtensionDirectory\ExtensionInfo::getAllExtensions();
    if (!$extensions) {
        // TODO: Handle errors here
    } else {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'index.html.twig', [
            'extensions' => $extensions
        ]);
    }
})->setName('index');


$app->get('/extension/{id}', function (Request $request, Response $response, $args) {
    $extensionInfo = ExtensionDirectory\ExtensionInfo::getExtensionInfo($args['id']);
    if (!$extensionInfo) {
        // TODO: Handle errors here
    } else {
        $view = Twig::fromRequest($request);
        return $view->render($response, 'extensionInfo.html.twig', [
            'extension' => $extensionInfo
        ]);
    }
})->setName('extension');

$app->get('/api/extension/{id}', function (Request $request, Response $response, $args) {
    $extensionInfo = ExtensionDirectory\ExtensionInfo::getExtensionInfo($args['id'], false);
    if (!$extensionInfo) {
        // TODO: Handle errors here
    } else {
        $response->getBody()->write(json_encode(['result' => $extensionInfo]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
});

$app->any('/api/list', function (Request $request, Response $response, $args) {
    $extensionInfo = ExtensionDirectory\ExtensionInfo::getAllExtensions(false);
    $GET = $request->getQueryParams();
    $POST = $request->getParsedBody();
    $filterType = $GET['type'] ?? $POST['type'] ?? null;

    // Filter the type if needed
    if (!empty($filterType)) {
        $extensionInfo = array_filter($extensionInfo, function ($extension) use ($filterType) {
            return $extension['type'] == $filterType;
        }, ARRAY_FILTER_USE_BOTH);
    }

    if (!$extensionInfo) {
        // TODO: Handle errors here
    } else {
        $response->getBody()->write(json_encode(['result' => $extensionInfo]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
});

$app->run();
