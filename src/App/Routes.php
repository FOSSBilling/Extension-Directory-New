<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use ExtensionDirectory\ResponseHelper;
use ExtensionDirectory\BadgeBuilder;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, $args) {
        $GET = $request->getQueryParams();
        $page = $GET['page'] ?? 1;
        $perPage = $GET['perPage'] ?? 25;
        $sort = ['direction' => $GET['direction'] ?? 'desc', 'by' => $GET['sort'] ?? 'name'];
        $filter = ['by' => $GET['by'] ?? '', 'mustBe' => $GET['mustBe'] ?? ''];

        $extensionList = ExtensionDirectory\ExtensionManager::getExtensionList(true, $this->get('cache'), $filter, $sort, $page, $perPage);
        if (!$extensionList) {
            // TODO: Handle errors here
        } else {
            return ResponseHelper::renderTwigTemplate($response, $request, 'index.html.twig', [
                'extensions' => $extensionList,
                'get' => $GET,
            ], $this->get('cache'));
        }
    })->setName('index');

    $app->get('/about', function (Request $request, Response $response, $args) {
        return ResponseHelper::renderTwigTemplate($response, $request, 'about.html.twig', [], $this->get('cache'));
    })->setName('about');

    $app->get('/extension/{id}', function (Request $request, Response $response, $args) {
        $extensionInfo = ExtensionDirectory\ExtensionManager::getExtensionInfo($args['id'], true, $this->get('cache'));
        if (!$extensionInfo) {
            // TODO: Handle errors here
        } else {
            return ResponseHelper::renderTwigTemplate($response, $request, 'extensionInfo.html.twig', [
                'extension' => $extensionInfo
            ], $this->get('cache'));
        }
    })->setName('extension');

    $app->group('/api', function ($group) {
        $group->any('/list', function (Request $request, Response $response, $args) {
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

            $extensionList = ExtensionDirectory\ExtensionManager::getExtensionList(false, $this->get('cache'), $filter);

            if (!$extensionList) {
                // TODO: Handle errors here
            } else {
                return ResponseHelper::renderJson(false, $extensionList, $response);
            }
        });

        $group->get('/extension/{id}', function (Request $request, Response $response, $args) {
            $extensionInfo = ExtensionDirectory\ExtensionManager::getExtensionInfo($args['id'], false, $this->get('cache'));
            if (!$extensionInfo) {
                // TODO: Handle errors here
            } else {
                return ResponseHelper::renderJson(false, $extensionInfo, $response);
            }
        });

        $group->get('/extension/{id}/badges/{type}', function (Request $request, Response $response, $args) {
            $badge = BadgeBuilder::buildABadge($args['id'], $args['type'], $this->get('cache'));
            $response->getBody()->write($badge);
            return $response;
        });
    });
};
