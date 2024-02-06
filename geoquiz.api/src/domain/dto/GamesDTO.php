<?php

namespace geoquiz\api\domain\dto;

use geoquiz\api\domain\entities\Games;

class GamesDTO extends DTO
{
    public string $game_id;
    public UsersDTO $user;
    public SeriesDTO $serie;
    public Difficulty_LevelsDTO $difficulty;
    public string $status;
    public int $score;
    public string $created_at;
    public ?string $finished_at;

    public function __construct(string $game_id, UsersDTO $user, SeriesDTO $serie, Difficulty_LevelsDTO $difficulty, string $status, int $score, string $created_at, string $finished_at = null)
    {
        $this->game_id = $game_id;
        $this->user = $user;
        $this->serie = $serie;
        $this->difficulty = $difficulty;
        $this->status = $status;
        $this->score = $score;
        $this->created_at = $created_at;
        $this->finished_at = $finished_at;
    }

    public function toModel($data = null) : Games
    {
        return Games::findOr($this->game_id, function () : Games {
            $newGame = new Games();
            $newGame->game_id = $this->game_id;
            return $newGame;
        })->fill([
            'user_id' => $this->user->user_id,
            'serie_id' => $this->serie->serie_id,
            'difficulty_id' => $this->difficulty->difficulty_id,
            'status' => $data['status'] ?? $this->status,
            'score' => $data['score'] ?? $this->score,
            'created_at' => $this->created_at,
            'finished_at' => $data['finished_at'] ?? $this->finished_at
        ]);
    }
}