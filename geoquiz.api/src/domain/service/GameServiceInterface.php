<?php

namespace geoquiz\api\domain\service;

use geoquiz\api\domain\dto\GamesDTO;

interface GameServiceInterface
{

    // Get all the difficulties available
    public function getDifficulties(): array;

    // Create a new game with the given difficulty and serie
    public function createGame(string $difficulty_id, string $serie_id, string $uuid): GamesDTO;

}