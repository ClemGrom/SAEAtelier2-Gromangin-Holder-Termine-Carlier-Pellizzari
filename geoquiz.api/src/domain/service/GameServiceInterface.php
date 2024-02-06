<?php

namespace geoquiz\api\domain\service;

use geoquiz\api\domain\dto\GamesDTO;

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

}