<?php

namespace geoquiz\api\app\action;

use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserGetUserFromEmail extends Action
{

    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $user = $this->gameService->getUserDetails($args['email']);

        $responseJson = [
            'type' => 'resource',
            'user' => $user,
        ];

        $response->getBody()->write(json_encode($responseJson));
        return $response->withHeader('Content-Type', 'application/json');

    }

}