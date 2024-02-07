<?php

namespace geoquiz\api\domain\middlewares;

use geoquiz\api\domain\service\GameServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpForbiddenException;

class BeforeCheckOwnership
{

    private GameServiceInterface $gameService;

    public function __construct(GameServiceInterface $gameService)
    {
        $this->gameService = $gameService;
    }

    public function __invoke(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        //si le gameId est présent dans les paramètres de la requête, on le récupère | sinon on continue
        $gameId = $request->getAttribute('gameId');
        if (!$gameId) {
            return $next->handle($request);
        }

        //On va aller vérifier que le jeu appartient bien à l'utilisateur

        //Récup de l'uiid de l'utilisateur
        $uuid = $request->getAttribute('uuid');

        //appel checkOwnership du service GameService
        if (!$this->gameService->checkOwnership($gameId, $uuid)) {
            //si le jeu n'appartient pas à l'utilisateur, on retourne une erreur 403
            throw new HttpForbiddenException($request, 'You are not allowed to access this game');
        }

    }
}