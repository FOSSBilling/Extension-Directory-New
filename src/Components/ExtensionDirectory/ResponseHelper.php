<?php

declare(strict_types=1);

namespace ExtensionDirectory;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ResponseHelper
{
    public function __construct(
        private Stats $stats
    ) {}

    public function renderTwigTemplate(Response $response, Request $request, string $template, array $data = []): Response
    {
        $view = Twig::fromRequest($request);
        $data['stats'] = $this->stats->getStats();
        return $view->render($response, $template, $data);
    }

    public function renderJson(bool $error, string|array $result, Response $response, ?int $code = null): Response
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
