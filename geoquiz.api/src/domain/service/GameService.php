<?php

namespace geoquiz\api\domain\service;

use geoquiz\api\domain\dto\GamesDTO;
use geoquiz\api\domain\dto\SeriesDTO;
use geoquiz\api\domain\dto\UsersDTO;
use geoquiz\api\domain\entities\Difficulty_Levels;
use geoquiz\api\domain\entities\Games;
use geoquiz\api\domain\entities\Users;
use Psr\Log\LoggerInterface;

class GameService implements GameServiceInterface
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function checkOwnership(string $gameId, string $uuid): bool
    {
        $this->logger->info('Checking ownership');
        return Games::where(['game_id' => $gameId, 'user_id' => $uuid])->exists();
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

    public function getGameDetails(string $gameId, string $uuid): GamesDTO
    {
        $this->logger->info('Getting game details');
        return Games::findOrFail($gameId)->toDTO();
    }

    public function submitGame(GamesDTO $game, int $score): GamesDTO
    {
        $this->logger->info('Submitting game');
        $game = $game->toModel([
                'status' => ($score > 0 ? 'terminée' : 'en cours'),
                'score' => $score,
                'finished_at' => ($score > 0 ? date('Y-m-d H:i:s') : null),
                'update' => true
            ]);
        $game->update();

        //if score is greater than 0, we update the user's score and total games played
        if ($score > 0) {
            $game->user()->first()->update([
                'total_score' => $game->user()->first()->total_score + $score,
                'total_games_played' => $game->user()->first()->total_games_played + 1
            ]);
        }

        return $game->toDTO();
    }

    public function getUserGames(string $userId): array
    {
        $this->logger->info('Getting user games');
        return Users::findOrFail($userId)->games->map(function ($game) {
            return $game->toDTO();
        })->toArray();
    }

    /**
     * @throws \Exception
     */
    public function createUser(UsersDTO $user): UsersDTO
    {
        //does the user already exist? if not, we create a new one | throw an exception if the user already exists
        if (Users::where('email', $user->email)->exists()) {
            throw new \Exception('User already exists');
        }

        $this->logger->info('Creating user');

        $user = $user->toModel();
        $user->save();
        return $user->toDTO();
    }

    public function getUserDetails(string $email): UsersDTO
    {
        $this->logger->info('Getting user details');
        return Users::where('email', $email)->first()->toDTO();
    }
}