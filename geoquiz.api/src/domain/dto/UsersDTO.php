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

    public function toModel($data = null) : Users
    {
        return Users::findOr($this->user_id, function () {
            $newUser = new Users();
            $newUser->user_id = $this->user_id;
            return $newUser;
        })->fill([
            'username' => $data['username'] ?? $this->username,
            'email' => $data['email'] ?? $this->email,
            'created_at' => $data['created_at'] ?? $this->created_at,
            'total_score' => $data['total_score'] ?? $this->total_score,
            'total_games_played' => $data['total_games_played'] ?? $this->total_games_played
        ]);
    }

}