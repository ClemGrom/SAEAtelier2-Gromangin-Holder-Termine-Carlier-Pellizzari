<?php

namespace geoquiz\auth\api\app\actions;

use geoquiz\auth\api\domain\dto\CredentialsDTO;
use geoquiz\auth\api\domain\provider\AuthServiceCredentialsException;
use geoquiz\auth\api\domain\service\auth\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SignUpAction
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function __invoke(Request $request, Response $response): Response
    {
        try {
        $params = json_decode((string) $request->getBody(), true) ?? [];

        $uuid = $params['uuid'] ?? null;
        $password = $params['password'] ?? null;

        if (null === $uuid || null === $password) {
            $response->getBody()->write(json_encode(['error' => 'Missing uuid or password']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        if (empty($uuid) || empty($password)) return $response->withStatus(400);

        $credentialsDTO = new CredentialsDTO($params['uuid'], $params['password']);
        $tokenDto = $this->authService->signup($credentialsDTO);

        // Encode token DTO to JSON
        $response->getBody()->write(json_encode($tokenDto));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (AuthServiceCredentialsException $e) {
            // Handle invalid credentials
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }
}