<?php

namespace geoquiz\gateway\app\action;


use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Slim\Exception\HttpUnauthorizedException;

class UserActionSignUp extends Action
{
    protected string $uriApi;

    public function __construct($uri, $uriApi)
    {
        parent::__construct($uri);
        $this->uriApi = $uriApi;
    }

    /**
     * @throws GuzzleException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        //récupérer la route demandée + la méthode et body + headers
        $route = $request->getUri()->getPath();
        $method = $request->getMethod();
        $body = $request->getParsedBody();
        $headers = $request->getHeaders();

        //Générer un UUID pour l'utilisateur
        $uuid = UUid::uuid4();

        //Envoyer la requête à l'API principale pour créer un profil utilisateur
        $responseProfil = $this->sendToProfile($request, $route, $method, $body, $headers, $uuid);

        //Envoyer la requête à l'API d'authentification pour créer un utilisateur
        $responseAuth = $this->sendToAuth($request, $route, $method, $body, $headers, $uuid);

        // Récupérer le corps de la réponse de l'API principale
        $bodyProfil = $responseProfil->getBody()->getContents();

        // Récupérer le corps de la réponse de l'API d'authentification
        $bodyAuth = $responseAuth->getBody()->getContents();

        // Décoder le corps de la réponse de l'API principale
        $bodyProfil = json_decode($bodyProfil, true);

        // Décoder le corps de la réponse de l'API d'authentification
        $bodyAuth = json_decode($bodyAuth, true);

        $responseJson = [
            'type' => 'resource',
            'token' => $bodyAuth['token'],
            'refreshToken' => $bodyAuth['refreshToken'],
            'user' => $bodyProfil['user']
        ];

        //retourner la réponse de la gateway
        $response = $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($responseJson));

        return $response;

    }

    /**
     * Envoyer la requête à l'API principale pour créer un profil utilisateur
     * @param $request ServerRequestInterface
     * @param $route string
     * @param $method string
     * @param $body array
     * @param $headers array
     * @param $uuid string
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendToProfile(ServerRequestInterface $request, string $route, string $method, array $body, array $headers, string $uuid) : ResponseInterface {
        //envoyer la requête à l'API principale pour créer un profil utilisateur
        //  /api/users/profile | Call route a modifier
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->uriApi, // $uriApi = Main API
            'timeout' => 60.0,
        ]);

        try {
            $responseProfil = $client->request($method, str_replace('signup', 'profile', $route), [
                'headers' => $headers,
                'json' => [
                    'user_id' => $uuid,
                    'username' => $body['username'],
                    'email' => $body['email']
                ]
            ]);
        } catch (GuzzleException $e) {
            //Retour erreur si impossible de créer le profil utilisateur pour x raison
            throw new HttpUnauthorizedException($request, "Impossible to register user profile");
        }

        //récupérer le code de retour
        $codeProfil = $responseProfil->getStatusCode();

        if ($codeProfil !== 200) {
            $bodyProfil = $responseProfil->getBody()->getContents();
            $bodyProfil = json_decode($bodyProfil, true);
            throw new HttpUnauthorizedException($request, $bodyProfil['message'], $bodyProfil['code']);
        }

        //retourner la réponse de l'API
        return $responseProfil;

    }

    /**
     * Envoyer la requête à l'API d'authentification pour créer un utilisateur
     * @param $request ServerRequestInterface
     * @param $route string
     * @param $method string
     * @param $body array
     * @param $headers array
     * @param $uuid string
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendToAuth(ServerRequestInterface $request, string $route, string $method, array $body, array $headers, string $uuid) : ResponseInterface
    {
        //envoyer la requête à l'API Auth pour créer un utilisateur uuid + password
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->uri, // $uri = Auth API
            'timeout' => 60.0,
        ]);

        $responseAuth = $client->request($method, $route, [
            'headers' => $headers,
            'json' => [
                'uuid' => $uuid,
                'password' => $body['password']
            ]
        ]);

        //récupérer le code de retour
        $codeAuth = $responseAuth->getStatusCode();

        //Continuer et register le profil utilisateur dans l'API principale si l'API Auth a retourné un code 200
        if ($codeAuth !== 200) {
            $bodyAuth = $responseAuth->getBody()->getContents();
            $bodyAuth = json_decode($bodyAuth, true);
            throw new HttpUnauthorizedException($request, $bodyAuth['message'], $bodyAuth['code']);
        }

        //retourner la réponse de l'API
        return $responseAuth;

    }

}