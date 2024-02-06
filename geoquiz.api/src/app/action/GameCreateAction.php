<?php

namespace geoquiz\api\app\action;

use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GameCreateAction extends Action
{

    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        //get user uuid from request params
        $uuid = $request->getAttribute('uuid');

        //get difficulty_id and serie_id from request body
        $body = $request->getParsedBody();
        $difficulty_id = $body['difficulty_id'];
        $serie_id = $body['serie_id'];

        //create the game
        $game = $this->gameService->createGame($difficulty_id, $serie_id, $uuid);

        //return the game as json
        $responseJson = [
            'type' => 'resource',
            'game' => $game,
            'links' => [
                'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('game_details', ['gameId' => $game->game_id])
            ]
        ];

        $response->getBody()->write(json_encode($responseJson));

        return $response->withHeader('Content-Type', 'application/json');

    }
}