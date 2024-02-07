<?php
declare(strict_types=1);

use geoquiz\api\app\action\DifficultiesListAction;
use geoquiz\api\app\action\GameCreateAction;
use geoquiz\api\app\action\GameDetailsAction;
use geoquiz\api\app\action\GameSubmitAction;
use geoquiz\api\app\action\UserGamesListAction;
use geoquiz\api\app\action\UserProfileAction;
use geoquiz\api\app\action\UserGetUserFromEmail;

use Slim\App;

return function( App $app):void {
    $app->options('/{routes:.+}', function ($request, $response) {
        return $response;
    });
    $app->group('/api', function($app) {

        $app->group('', function ($app) {

            // Route pour récupérer les difficultés disponibles
            $app->get('/difficulties[/]', DifficultiesListAction::class)->setName('difficulties_list');

            $app->group('/games', function ($app) {

                // Route pour créer une nouvelle partie
                $app->post('[/]', GameCreateAction::class)->setName('game_create');

                $app->group('/{gameId}', function ($app) {

                    // Route pour récupérer les détails d'une partie spécifique (statut, score, etc.)
                    $app->get('[/]', GameDetailsAction::class)->setName('game_details');

                    // Route pour soumettre une partie qui démarre ou est finie
                    $app->post('/submit[/]', GameSubmitAction::class)->setName('game_submit');

                })->add(
                    $app->getContainer()->get('checkOwnership')
                );

            });

        })->add(
            $app->getContainer()->get('checkJwt')
        );

        $app->group('/users', function ($app) {
            // Route pour lister les parties d'un utilisateur
            $app->get('/{userId}/games[/]', UserGamesListAction::class)->add(
                $app->getContainer()->get('checkJwt')
            )->setName('user_games_list');

            //create user profile route without checkjwt check
            $app->post('/profile[/]', UserProfileAction::class)->add(
                $app->getContainer()->get('checkOwnership')
            )->setName('user_profile');

            //Get only user related infos
            $app->get('/profile/{email}[/]', UserGetUserFromEmail::class)->setName('user_profile_get_only');
        });

    });
};