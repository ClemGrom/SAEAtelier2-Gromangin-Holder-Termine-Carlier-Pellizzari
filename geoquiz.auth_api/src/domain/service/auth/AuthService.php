<?php

namespace geoquiz\auth\api\domain\service\auth;

use geoquiz\auth\api\domain\dto\CredentialsDTO;
use geoquiz\auth\api\domain\dto\TokenDTO;
use geoquiz\auth\api\domain\dto\UserDTO;
use geoquiz\auth\api\domain\entites\User;
use geoquiz\auth\api\domain\provider\AuthProvider;
use geoquiz\auth\api\domain\provider\AuthServiceCredentialsException;
use geoquiz\auth\api\domain\provider\JwtManager;
use Psr\Log\LoggerInterface;
use geoquiz\auth\api\domain\provider\AuthProviderCredentialsException;
use geoquiz\auth\api\domain\provider\JwtManagerExpiredTokenException;
use geoquiz\auth\api\domain\provider\JwtManagerInvalidTokenException;

class AuthService implements AuthServiceInterface
{
    private AuthProvider $authProvider;
    private JwtManager $jwtManager;
    private LoggerInterface $logger;

    public function __construct(AuthProvider $authProvider, JwtManager $jwtManager, LoggerInterface $logger)
    {
        $this->authProvider = $authProvider;
        $this->jwtManager = $jwtManager;
        $this->logger = $logger;
    }

    /**
     * @throws AuthProviderCredentialsException
     * @throws AuthServiceCredentialsException
     */
    public function signup(CredentialsDTO $credentialsDTO): TokenDTO
    {
        $user = User::find($credentialsDTO->uuid);
        if (!is_null($user)) throw new AuthServiceCredentialsException("User already exists");

        $user = new User();
        $user->uuid = $credentialsDTO->uuid;
        $user->password = $this->authProvider->register($credentialsDTO->password);
        $user->save();

        // Récupération du token utilisateur en le connectant
        $this->authProvider->checkCredentials($user->uuid, $credentialsDTO->password);
        $user = $this->authProvider->getAuthenticatedUser(); // Assuming this returns an array of user data.
        $jwt = $this->jwtManager->create(['uuid' => $user['uuid']]);

        return new TokenDTO($jwt, $user['refresh_token']);
    }

    /**
     * @throws AuthServiceCredentialsException
     */
    public function signin(CredentialsDTO $credentialsDTO): TokenDTO
    {
        try {
            $this->authProvider->checkCredentials($credentialsDTO->uuid, $credentialsDTO->password);
            $user = $this->authProvider->getAuthenticatedUser(); // Assuming this returns an array of user data.
            $jwt = $this->jwtManager->create(['uuid' => $user['uuid']]);
            return new TokenDTO($jwt, $user['refresh_token']);
        } catch (AuthProviderCredentialsException $e) {
            $this->logger->warning('Auth attempt failed for ' . $credentialsDTO->uuid . ' : ' . $e->getMessage());
            throw new AuthServiceCredentialsException($e->getMessage());
        }
    }

    /**
     * @throws AuthServiceValidateException
     */
    public function validate(TokenDTO $tokenDTO): UserDTO
    {
        try {
            $payload = $this->jwtManager->validate($tokenDTO->token);
            return new UserDTO($payload);
        } catch (JwtManagerExpiredTokenException $e) {
            $this->logger->warning('JWT expired: ' . $e->getMessage());
            throw new AuthServiceValidateException('Expired jwt token, try refreshing it');
        } catch (JwtManagerInvalidTokenException $e) {
            $this->logger->warning('Invalid JWT: ' . $e->getMessage());
            throw new AuthServiceValidateException('Invalid jwt token');
        }
    }

    public function refresh(TokenDTO $tokenDTO): TokenDTO
    {
        try {
            $this->authProvider->checkRefreshToken($tokenDTO->refreshToken); // This method is now in line with earlier provided code.
            $user = $this->authProvider->getAuthenticatedUser(); // Assuming this returns an array of user data.
            $newJwt = $this->jwtManager->create(['uuid' => $user['uuid']]);
            return new TokenDTO($newJwt, $user['refresh_token']);
        } catch (AuthProviderRefreshTokenException $e) {
            $this->logger->warning("Failed JWT refresh: " . $e->getMessage());
            throw new AuthServiceCredentialsException('Refresh token invalid or expired');
        }
    }

    public function activate_signup(TokenDTO $tokenDTO): void
    {
        // This feature is not yet implemented as per the exercise.
    }

    public function reset_password(TokenDTO $tokenDTO, CredentialsDTO $credentialsDTO): void
    {
        // This feature is not yet implemented as per the exercise.
    }
}