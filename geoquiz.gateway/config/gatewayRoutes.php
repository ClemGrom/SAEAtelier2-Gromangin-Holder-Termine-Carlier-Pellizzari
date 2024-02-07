<?php

use geoquiz\gateway\app\action\UserActionSigIn;
use geoquiz\gateway\app\action\UserActionSignUp;
use geoquiz\gateway\app\action\UserActionOther;
use geoquiz\gateway\app\action\MainAction;
use Slim\App;

return function(App $app) {
    $app->group('/api', function($app) {
        $app->group('/users', function($app) {
            $app->post('/signin[/]', UserActionSigIn::class);
            $app->get('/validate[/]', UserActionOther::class);
            $app->post('/refresh[/]', UserActionOther::class);
            $app->post('/signup[/]', UserActionSignUp::class);
        });

        $app->group('', function ($app) {
            // Route pour récupérer les difficultés disponibles
            $app->get('/difficulties[/]', MainAction::class)->setName('difficulties_list');

            $app->group('/games', function ($app) {
                // Route pour créer une nouvelle partie
                $app->post('[/]', MainAction::class)->setName('game_create');

                $app->group('/{gameId}', function ($app) {
                    // Route pour récupérer les détails d'une partie spécifique (statut, score, etc.)
                    $app->get('[/]', MainAction::class)->setName('game_details');

                    // Route pour soumettre une partie qui démarre ou est finie
                    $app->post('/submit[/]', MainAction::class)->setName('game_submit');
                });
            });
        });

        $app->group('/users', function ($app) {
            // Route pour lister les parties d'un utilisateur
            $app->get('/{userId}/games[/]', MainAction::class)->setName('user_games_list');

            //create user profile route without checkjwt check
            $app->post('/profile[/]', MainAction::class)->setName('user_profile');

            //Get only user related infos
            $app->get('/profile/{email}[/]', MainAction::class)->setName('user_profile_get_only');
        });

    });
};