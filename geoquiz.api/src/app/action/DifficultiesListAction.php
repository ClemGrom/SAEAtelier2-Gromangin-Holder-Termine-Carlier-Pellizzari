<?php

namespace geoquiz\api\app\action;

use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class DifficultiesListAction extends Action
{

    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $difficulties = $this->gameService->getDifficulties();

        $responseJson = [
            'type' => 'collection',
            'difficulties' => $difficulties,
            'links' => [
                'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('difficulties_list')
            ]
        ];

        $response->getBody()->write(json_encode($responseJson));

        return $response->withHeader('Content-Type', 'application/json');
    }
}