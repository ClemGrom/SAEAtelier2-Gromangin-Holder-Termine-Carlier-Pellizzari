<?php

use geoquiz\auth\api\app\actions\SignInAction;
use geoquiz\auth\api\app\actions\SignUpAction;
use Psr\Container\ContainerInterface;
use geoquiz\auth\api\app\actions\ValidateTokenAction;
use geoquiz\auth\api\app\actions\RefreshTokenAction;
use geoquiz\auth\api\domain\service\auth\AuthService;

return [
    SignInAction::class => function (ContainerInterface $container) {
        return new SignInAction($container->get(AuthService::class));
    },
    ValidateTokenAction::class => function (ContainerInterface $container) {
        return new ValidateTokenAction($container->get(AuthService::class));
    },
    RefreshTokenAction::class => function (ContainerInterface $container) {
        return new RefreshTokenAction($container->get(AuthService::class));
    },
    SignUpAction::class => function (ContainerInterface $container) {
        return new SignUpAction($container->get(AuthService::class));
    }
];