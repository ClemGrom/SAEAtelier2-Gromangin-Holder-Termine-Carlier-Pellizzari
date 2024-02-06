<?php
declare(strict_types=1);

use geoquiz\api\app\action\DifficultiesListAction;
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

        // Route pour récupérer les difficultés disponibles
        $app->get('/difficulties[/]', DifficultiesListAction::class)->setName('difficulties_list');

        $app->group('/games', function($app) {

            // Route pour créer une nouvelle partie
            $app->post('[/]', GameCreateAction::class)->setName('game_create');

            $app->group('/{gameId}', function($app) {

                // Route pour récupérer les détails d'une partie spécifique (statut, score, etc.)
                $app->get('[/]', GameDetailsAction::class)->setName('game_details');

                // Route pour soumettre une partie qui démarre ou est finie
                $app->post('/submit[/]', GameSubmitAction::class)->setName('game_submit');

            })->add(
                $app->getContainer()->get('checkOwnership')
            );

        });

        // Route pour lister les parties d'un utilisateur
        $app->get('/users/{userId}/games', UserGamesListAction::class)->setName('user_games_list');

    })->add(
        $app->getContainer()->get('checkJwt')
    );

    //create user profile route

};