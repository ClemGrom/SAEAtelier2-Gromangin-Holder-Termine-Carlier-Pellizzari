<?php

use geoquiz\gateway\app\action\UserActionSigIn;
use geoquiz\gateway\app\action\UserActionSignUp;
use geoquiz\gateway\app\action\UserActionOther;
use Slim\App;

return function(App $app) {
    $app->group('/api/', function($app) {
        $app->group('users', function($app) {
            $app->post('/signin[/]', UserActionSigIn::class);
            $app->get('/validate[/]', UserActionOther::class);
            $app->post('/refresh[/]', UserActionOther::class);
            $app->post('/signup[/]', UserActionSignUp::class);
        });


    });
};