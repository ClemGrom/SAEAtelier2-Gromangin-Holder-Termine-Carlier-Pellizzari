<?php

namespace geoquiz\api\domain\dto;

use geoquiz\api\domain\entities\Users;

class UsersDTO extends DTO
{

    public string $user_id;
    public string $username;
    public string $email;
    public string $created_at;
    public int $total_score;
    public int $total_games_played;

    public function __construct(string $UUID, string $username, string $email, string $created_at, int $total_score, int $total_games_played)
    {
        $this->user_id = $UUID;
        $this->username = $username;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->total_score = $total_score;
        $this->total_games_played = $total_games_played;
    }

    public function toModel() : Users
    {
        return Users::findOr($this->user_id, function () {
            $newUser = new Users();
            $newUser->user_id = $this->user_id;
            return $newUser;
        })->fill([
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'total_score' => $this->total_score,
            'total_games_played' => $this->total_games_played
        ]);
    }

}