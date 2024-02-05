<?php

namespace geoquiz\auth\api\domain\entites;

use Illuminate\Database\Eloquent\Model;
use geoquiz\auth\api\domain\dto\UserDTO;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'uuid',
        'password',
        'active',
        'activation_token',
        'activation_token_expiration_date',
        'refresh_token',
        'refresh_token_expiration_date',
        'reset_passwd_token',
        'reset_passwd_token_expiration_date'
    ];
    protected $hidden = [
        'password',
        'activation_token',
        'refresh_token',
        'reset_passwd_token'
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    public $timestamps = false;

    public function toDTO (): UserDTO
    {
        $attributes = [
            'uuid' => $this->uuid,
            'password' => $this->password
        ];
        return new UserDTO($attributes);
    }
}