<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use ExtensionDirectory\ResponseHelper;
use ExtensionDirectory\BadgeBuilder;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, $args) {
        $extensionList = ExtensionDirectory\ExtensionInfo::getAllExtensions(true, $this->get('cache'));
        if (!$extensionList) {
            // TODO: Handle errors here
        } else {
            return ResponseHelper::renderTwigTemplate($response, $request, 'index.html.twig', [
                'extensions' => $extensionList
            ]);
        }
    })->setName('index');

    $app->get('/extension/{id}', function (Request $request, Response $response, $args) {
        $extensionInfo = ExtensionDirectory\ExtensionInfo::getExtensionInfo($args['id'], true, $this->get('cache'));
        if (!$extensionInfo) {
            // TODO: Handle errors here
        } else {
            return ResponseHelper::renderTwigTemplate($response, $request, 'extensionInfo.html.twig', [
                'extension' => $extensionInfo
            ]);
        }
    })->setName('extension');

    $app->group('/api', function ($group) {
        $group->any('/list', function (Request $request, Response $response, $args) {
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

        $group->get('/extension/{id}', function (Request $request, Response $response, $args) {
            $extensionInfo = ExtensionDirectory\ExtensionInfo::getExtensionInfo($args['id'], false, $this->get('cache'));
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
