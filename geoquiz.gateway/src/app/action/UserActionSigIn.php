<?php

namespace geoquiz\gateway\app\action;

use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;

class UserActionSigIn extends Action
{

    protected string $uriApi;

    public function __construct($uri, $uriApi)
    {
        parent::__construct($uri);
        $this->uriApi = $uriApi;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args){
        //Récupérer le header Authorization Basic
        $tokenHeader = $request->getHeaderLine('Authorization');

        //Décoder le header
        $credentials = !empty($tokenHeader) ? trim(str_replace('Basic', '', $tokenHeader)) : '';
        $credentials = base64_decode($credentials);
        $email = substr($credentials, 0, strpos($credentials, ':'));
        $password = substr($credentials, strpos($credentials, ':') + 1);

        //Récupérer la route demandée + la méthode et body + headers
        $userDetails = $this->getUserFromEmail(
            $request,
            $request->getUri()->getPath(),
            $request->getMethod(),
            $request->getParsedBody(),
            $request->getHeaders(),
            $email
        );
        $bodyApi = $userDetails->getBody()->getContents();
        $bodyApi = json_decode($bodyApi, true);

        //Réencoder le header Authorization Basic et le remettre avec uuid:password
        $credentials = base64_encode($bodyApi['user']['user_id'] . ':' . $password);

        //suprimer le header Authorization
        $request = $request->withoutHeader('Authorization');

        //remplacer le header Authorization
        $request = $request->withHeader('Authorization', 'Basic ' . $credentials);

        //heriter
        return parent::__invoke($request, $response, $args);

    }

    /**
     * Envoyer la requête à l'API principale pour récupérer un utilisateur à partir de son email
     * @param $request ServerRequestInterface
     * @param $route string
     * @param $method string
     * @param $body array
     * @param $headers array
     * @param string $email
     * @return ResponseInterface
     */
    public function getUserFromEmail(ServerRequestInterface $request, string $route, string $method, ?array $body, array $headers, string $email) : ResponseInterface {
        //envoyer la requête à l'API principale pour créer un profil utilisateur
        //  /api/users/profile | Call route a modifier
        $client = new \GuzzleHttp\Client([
            'base_uri' => $this->uriApi, // $uriApi = Main API
            'timeout' => 60.0,
        ]);

        try {
            $responseProfil = $client->request("GET", str_replace('signin', 'profile' . '/' . $email, $route), [
                'headers' => $headers,
                'json' => $body
            ]);
        } catch (GuzzleException $e) {
            //Retour erreur si impossible de créer le profil utilisateur pour x raison
            throw new HttpUnauthorizedException($request, $e->getMessage());
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



}