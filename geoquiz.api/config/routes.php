<?php
declare(strict_types=1);

use geoquiz\api\app\action\SeriesListAction;
use geoquiz\api\app\action\GameCreateAction;
use geoquiz\api\app\action\GameDetailsAction;
use geoquiz\api\app\action\GameSubmitAction;
use geoquiz\api\app\action\UserGamesListAction;

use Slim\App;

return function( App $app):void {

    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });
    $app->group('/api', function($app) {

        // Route pour afficher les séries disponibles
        $app->get('/series', SeriesListAction::class)->setName('series_list');

        // Route pour créer une nouvelle partie
        $app->post('/games', GameCreateAction::class)->setName('game_create');

        // Route pour récupérer les détails d'une partie spécifique (statut, score, etc.)
        $app->get('/games/{gameId}', GameDetailsAction::class)->setName('game_details');

        // Route pour soumettre une réponse dans une partie (placer une photo)
        $app->post('/games/{gameId}/submit', GameSubmitAction::class)->setName('game_submit');

        // Route pour lister les parties d'un utilisateur
        $app->get('/users/{userId}/games', UserGamesListAction::class)->setName('user_games_list');

    })->add(
        $app->getContainer()->get('checkJwt')
    );
};