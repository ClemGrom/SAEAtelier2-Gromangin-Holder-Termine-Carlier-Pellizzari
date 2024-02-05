<?php

namespace geoquiz\auth\api\domain\dto;

class UserDTO
{
    public string $uuid;
    public string $password;
    public string $activationToken;
    public ?string $activationTokenExpirationDate; // Optional as it can be null
    public ?string $refreshToken; // Optional as it can be null
    public ?string $refreshTokenExpirationDate; // Optional as it can be null

    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}