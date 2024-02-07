<?php

namespace geoquiz\api\app\action;

use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Routing\RouteContext;

class UserGamesListAction extends Action
{
    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        if ($request->getAttribute('uuid') !== $args['userId']) {
            throw new HttpForbiddenException($request, 'You are not allowed to access this game list');
        }

        $userId = $args['userId'];
        $games = $this->gameService->getUserGames($userId);

        $responseJson = [
            'type' => 'collection',
            'games' => $games,
            'links' => [
                'self' => RouteContext::fromRequest($request)->getRouteParser()->urlFor('user_games_list', ['userId' => $userId])
            ]
        ];

        $response->getBody()->write(json_encode($responseJson));
        return $response->withHeader('Content-Type', 'application/json');

    }
}