<?php

use geoquiz\auth\api\app\actions\SignUpAction;
use Slim\App;
use geoquiz\auth\api\app\actions\SignInAction;
use geoquiz\auth\api\app\actions\ValidateTokenAction;
use geoquiz\auth\api\app\actions\RefreshTokenAction;

return function(App $app) {
    $app->group('/api/users', function($group) {
        $group->post('/signin[/]', SignInAction::class);
        $group->get('/validate[/]', ValidateTokenAction::class);
        $group->post('/refresh[/]', RefreshTokenAction::class);
        $group->post('/signup[/]', SignUpAction::class);
    });
};