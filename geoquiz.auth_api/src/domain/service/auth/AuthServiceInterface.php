<?php

namespace geoquiz\auth\api\domain\service\auth;

use geoquiz\auth\api\domain\dto\CredentialsDTO;
use geoquiz\auth\api\domain\dto\TokenDTO;
use geoquiz\auth\api\domain\dto\UserDTO;

interface AuthServiceInterface {
    public function signup(CredentialsDTO $credentialsDTO): TokenDTO;
    public function signin(CredentialsDTO $credentialsDTO): TokenDTO;
    public function validate(TokenDTO $tokenDTO): UserDTO;
    public function refresh(TokenDTO $tokenDTO): TokenDTO;
    public function activate_signup(TokenDTO $tokenDTO): void;
    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void;
}