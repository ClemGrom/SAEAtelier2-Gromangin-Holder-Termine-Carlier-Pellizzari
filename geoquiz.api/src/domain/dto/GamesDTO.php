<?php

namespace geoquiz\api\domain\dto;

use geoquiz\api\domain\dto\DTO;

class GamesDTO extends DTO
{
//-- Parties
//CREATE TABLE games (
//                       game_id CHAR(36) PRIMARY KEY NOT NULL,
//                       user_id CHAR(36) NOT NULL,
//                       serie_id CHAR(36) NOT NULL,
//                       difficulty_id CHAR(36) NOT NULL,
//                       status ENUM('créée', 'en cours', 'terminée') NOT NULL,
//                       score INT DEFAULT 0,
//                       created_at DATETIME NOT NULL,
//                       finished_at DATETIME,
//                       FOREIGN KEY (user_id) REFERENCES users(user_id),
//                       FOREIGN KEY (serie_id) REFERENCES series(serie_id),
//                       FOREIGN KEY (difficulty_id) REFERENCES difficulty_levels(difficulty_id)
//);

    public string $game_id;
    public string $user_id;
    public string $serie_id;
    public string $difficulty_id;
    public string $status;
    public int $score;
    public string $created_at;
    public string $finished_at;

    public function __construct(string $game_id, string $user_id, string $serie_id, string $difficulty_id, string $status, int $score, string $created_at, string $finished_at)
    {
        $this->game_id = $game_id;
        $this->user_id = $user_id;
        $this->serie_id = $serie_id;
        $this->difficulty_id = $difficulty_id;
        $this->status = $status;
        $this->score = $score;
        $this->created_at = $created_at;
        $this->finished_at = $finished_at;
    }

    public function toModel()
    {
        return GamesDTO::findOr($this->game_id, function () {
            $newGame = new GamesDTO();
            $newGame->game_id = $this->game_id;
            return $newGame;
        })->fill([
            'user_id' => $this->user_id,
            'serie_id' => $this->serie_id,
            'difficulty_id' => $this->difficulty_id,
            'status' => $this->status,
            'score' => $this->score,
            'created_at' => $this->created_at,
            'finished_at' => $this->finished_at
        ]);
    }
}