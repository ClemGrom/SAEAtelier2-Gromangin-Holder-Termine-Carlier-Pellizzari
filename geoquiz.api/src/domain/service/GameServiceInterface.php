<?php

namespace geoquiz\api\domain\service;

use geoquiz\api\domain\dto\GamesDTO;
use geoquiz\api\domain\dto\UsersDTO;

interface GameServiceInterface
{
    // Check if the game belongs to the user
    public function checkOwnership(string $gameId, string $uuid): bool;

    // Get all the difficulties available
    public function getDifficulties(): array;

    // Create a new game with the given difficulty and serie
    public function createGame(string $difficulty_id, string $serie_id, string $uuid): GamesDTO;

    // Get the details of a game
    public function getGameDetails(string $gameId, string $uuid): GamesDTO;

    // Submit a game
    public function submitGame(GamesDTO $game, int $score): GamesDTO;

    // Get the list of games for a user
    public function getUserGames(string $userId): array;

    // Create a new user
    public function createUser(UsersDTO $user): UsersDTO;

    // Get the user details from the user uuid
    public function getUserDetails(string $email): UsersDTO;

}