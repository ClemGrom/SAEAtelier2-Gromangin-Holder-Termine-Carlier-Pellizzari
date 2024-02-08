<?php

namespace geoquiz\api\app\action;

use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GameSubmitAction extends Action
{
    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $gameId = $args['gameId'];
        $uuid = $request->getAttribute('uuid');
        $score = $request->getParsedBody()['score'];

        $gamePrevious = $this->gameService->getGameDetails($gameId, $uuid);
        $gameActualized = $this->gameService->submitGame($gamePrevious, $score);

        $responseJson = [
            'type' => 'resource',
            'game' => $gameActualized,
            'links' => [
                'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('game_details', ['gameId' => $gameId])
            ]
        ];
        $response->getBody()->write(json_encode($responseJson));
        return $response->withHeader('Content-Type', 'application/json');
    }
}