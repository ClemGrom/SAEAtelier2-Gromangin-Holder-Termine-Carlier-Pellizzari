<?php

namespace geoquiz\api\domain\entities;

use geoquiz\api\domain\dto\UsersDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['user_id', 'username', 'email', 'created_at', 'total_score', 'total_games_played'];

    public function games(): HasMany
    {
        return $this->hasMany('geoquiz\api\domain\entities\Games', 'user_id');
    }

    public function toDTO(): UsersDTO
    {
        return new UsersDTO(
            $this->user_id,
            $this->username,
            $this->email,
            $this->created_at,
            $this->total_score,
            $this->total_games_played
        );
    }

}