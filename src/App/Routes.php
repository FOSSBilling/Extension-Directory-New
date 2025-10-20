<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    // Extract services once to avoid repetitive ->get() calls
    $container = $app->getContainer();
    $extensionManager = $container->get(\ExtensionDirectory\ExtensionManager::class);
    $responseHelper = $container->get(\ExtensionDirectory\ResponseHelper::class);
    $badgeBuilder = $container->get(\ExtensionDirectory\BadgeBuilder::class);

    $app->get('/', function (Request $request, Response $response, $args) use ($extensionManager, $responseHelper) {
        $GET = $request->getQueryParams();
        $page = $GET['page'] ?? 1;
        $perPage = $GET['perPage'] ?? 25;
        $sort = ['direction' => $GET['direction'] ?? 'desc', 'by' => $GET['sort'] ?? 'name'];
        $filter = ['by' => $GET['by'] ?? '', 'mustBe' => $GET['mustBe'] ?? ''];

        $extensionList = $extensionManager->getExtensionList(true, $filter, $sort, $page, $perPage);
        if (!$extensionList) {
            return $responseHelper->renderTwigTemplate($response, $request, 'index.html.twig', [
                'extensions' => [],
                'get' => $GET,
                'error' => 'Unable to load extensions. Please try again later.',
            ]);
        }

        return $responseHelper->renderTwigTemplate($response, $request, 'index.html.twig', [
            'extensions' => $extensionList,
            'get' => $GET,
        ]);
    })->setName('index');

    $app->get('/about', function (Request $request, Response $response, $args) use ($responseHelper) {
        return $responseHelper->renderTwigTemplate($response, $request, 'about.html.twig');
    })->setName('about');

    $app->get('/extension/{id}', function (Request $request, Response $response, $args) use ($extensionManager, $responseHelper) {
        $extensionInfo = $extensionManager->getExtensionInfo($args['id'], true);
        if (!$extensionInfo) {
            // Extension not found - return 404
            $response = $response->withStatus(404);
            return $responseHelper->renderTwigTemplate($response, $request, 'index.html.twig', [
                'extensions' => [],
                'get' => [],
                'error' => 'Extension "' . htmlspecialchars($args['id']) . '" not found.',
            ]);
        }

        return $responseHelper->renderTwigTemplate($response, $request, 'extensionInfo.html.twig', [
            'extension' => $extensionInfo
        ]);
    })->setName('extension');

    $app->group('/api', function ($group) use ($extensionManager, $responseHelper, $badgeBuilder) {
        $group->any('/list', function (Request $request, Response $response, $args) use ($extensionManager, $responseHelper) {
            $GET = $request->getQueryParams();
            $POST = $request->getParsedBody();
            $filterType = $GET['type'] ?? $POST['type'] ?? null;

            if (!empty($filterType)) {
                $filter = [
                    'by' => 'type',
                    'mustBe' => $filterType,
                ];
            } else {
                $filter = [];
            }

            $extensionList = $extensionManager->getExtensionList(false, $filter);

            if (!$extensionList) {
                return $responseHelper->renderJson(true, 'Unable to load extensions', $response, 500);
            }

            return $responseHelper->renderJson(false, $extensionList, $response);
        });

        $group->get('/extension/{id}', function (Request $request, Response $response, $args) use ($extensionManager, $responseHelper) {
            $extensionInfo = $extensionManager->getExtensionInfo($args['id'], false);
            if (!$extensionInfo) {
                return $responseHelper->renderJson(true, 'Extension not found', $response, 404);
            }

            return $responseHelper->renderJson(false, $extensionInfo, $response);
        });

        $group->get('/extension/{id}/badges/{type}', function (Request $request, Response $response, $args) use ($badgeBuilder) {
            $GET = $request->getQueryParams();
            $badge = $badgeBuilder->buildABadge($args['id'], $args['type'], $GET['color'] ?? null);
            $response = $response->withHeader('Content-Type', 'image/svg+xml');
            $response->getBody()->write($badge);
            return $response;
        })->setName('badge');
    });
};
