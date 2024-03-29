<?php

namespace geoquiz\auth\api\domain\provider;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use geoquiz\auth\api\domain\entites\User;

class AuthProvider
{
    private User $currentAuthenticatedUserEntity;

    /**
     * @throws Exception
     */
    private function generateRefreshToken(User $user): void
    {
        $user->refresh_token = bin2hex(random_bytes(32));
        $user->refresh_token_expiration_date = date('Y-m-d H:i:s', time() + 3600);
        $user->save();
    }

    /**
     * @throws AuthProviderCredentialsException
     * @throws Exception
     */
    public function checkCredentials(string $uuid, string $password): void
    {
        try {
            $user = User::where('uuid', $uuid)->firstOrFail();

            if (!password_verify($password, $user->password)) {
                throw new AuthProviderCredentialsException("Wrong password");
            }

            $this->generateRefreshToken($user);
            $this->currentAuthenticatedUserEntity = $user;

        } catch (ModelNotFoundException $e) {
            throw new AuthProviderCredentialsException("User not found");
        }
    }

    public function checkRefreshToken(string $refreshToken): void
    {
        try {
            $user = User::where('refresh_token', $refreshToken)->firstOrFail();
            if (new \DateTime() > new \DateTime($user->refresh_token_expiration_date)) {
                throw new AuthProviderTokenException("Refresh token expired");
            }
            // Refresh token is valid, proceed with refreshing the token.
            $this->generateRefreshToken($user);
            $this->currentAuthenticatedUserEntity = $user;
        } catch (ModelNotFoundException $e) {
            throw new AuthProviderTokenException("Invalid refresh token");
        }
    }

    //reçois un mot de passe en clair et retourne un hash du mot de passe
    public function register(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function activate(string $token): void
    {

    }

    public function resetPassword(string $token, string $old_password, string $new_password): void
    {

    }

    public function getAuthenticatedUser(): array
    {
        return [
            'uuid' => $this->currentAuthenticatedUserEntity->uuid,
            'refresh_token' => $this->currentAuthenticatedUserEntity->refresh_token,
        ];
    }
}