<?php

namespace geoquiz\auth\api\domain\dto;

namespace geoquiz\auth\api\domain\dto;

class TokenDTO
{
    public string $token;
    public string $refreshToken;

    public function __construct(string $token, string $refreshToken)
    {
        $this->token = $token;
        $this->refreshToken = $refreshToken;
    }
}