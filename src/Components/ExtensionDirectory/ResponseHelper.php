<?php

namespace ExtensionDirectory;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ResponseHelper
{
    public static function renderTwigTemplate(Response $response, Request $request, string $template, array $data = [], ?object $cacheService = null): Response
    {
        $view = Twig::fromRequest($request);
        if (is_object($cacheService)) {
            $data['stats'] = Stats::getStats($cacheService);
        }
        return $view->render($response, $template, $data);
    }

    public static function renderJson(bool $error, string|array $result, Response $response, ?int $code = null)
    {
        if ($error) {
            $response->getBody()->write(json_encode(['error' => ['message' => $result]]));
            $code ??= (date('m-d') == '04-01') ? 418 : 500;
        } else {
            $response->getBody()->write(json_encode(['result' => $result]));
            $code ??= 200;
        }
        return $response->withHeader('Content-Type', 'application/json')->withStatus($code);
    }
}
