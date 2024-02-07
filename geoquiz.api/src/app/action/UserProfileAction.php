<?php

namespace geoquiz\api\app\action;

use geoquiz\api\domain\dto\UsersDTO;
use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserProfileAction extends Action
{
    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $data = $request->getParsedBody();

        $user = $this->gameService->createUser(new UsersDTO(
            $data['user_id'],
            $data['username'],
            $data['email'],
            date('Y-m-d H:i:s'),
            0,
            0
        ));

        $responseJson = [
            'type' => 'resource',
            'user' => $user,
        ];

        $response->getBody()->write(json_encode($responseJson));
        return $response->withHeader('Content-Type', 'application/json');

    }
}