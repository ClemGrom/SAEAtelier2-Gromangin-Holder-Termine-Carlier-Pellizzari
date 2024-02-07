<?php

use geoquiz\gateway\app\action\UserActionSignUp;
use Slim\App;

return function(App $app) {
    $app->group('/api/', function($app) {
        $app->group('users', function($app) {
            $app->post('/signin[/]', UserActionSignUp::class);
            $app->get('/validate[/]', UserActionSignUp::class);
            $app->post('/refresh[/]', UserActionSignUp::class);
            $app->post('/signup[/]', UserActionSignUp::class);
        });


    });
};