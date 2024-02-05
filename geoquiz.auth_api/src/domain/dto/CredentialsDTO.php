<?php

namespace geoquiz\auth\api\domain\dto;

class CredentialsDTO
{
    public string $uuid;
    public string $password;

    public function __construct(string $uuid, string $password)
    {
        $this->uuid = $uuid;
        $this->password = $password;
    }
}