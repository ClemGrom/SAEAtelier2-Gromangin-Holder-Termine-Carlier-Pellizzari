<?php

namespace geoquiz\api\domain\service;

use geoquiz\api\domain\dto\Difficulty_LevelsDTO;
use geoquiz\api\domain\dto\GamesDTO;
use geoquiz\api\domain\dto\SeriesDTO;
use geoquiz\api\domain\dto\UsersDTO;
use geoquiz\api\domain\entities\Difficulty_Levels;
use geoquiz\api\domain\entities\Users;
use Psr\Log\LoggerInterface;

class GameService implements GameServiceInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getDifficulties(): array
    {
        $this->logger->info('Getting difficulties');
        return Difficulty_Levels::all()->map(function ($difficulty) {
            return $difficulty->toDTO();
        })->toArray();
    }

    public function createGame(string $difficulty_id, string $serie_id, string $uuid): GamesDTO
    {
        $this->logger->info('Creating game');
        $game = new GamesDTO(
            uniqid(),
            Users::findOrFail($uuid)->toDTO(),
            new SeriesDTO($serie_id),
            Difficulty_Levels::findOrFail($difficulty_id)->toDTO(),
            'créée',
            0,
            date('Y-m-d H:i:s')
        );

        $game->toModel()->save();

        return $game;
    }
}