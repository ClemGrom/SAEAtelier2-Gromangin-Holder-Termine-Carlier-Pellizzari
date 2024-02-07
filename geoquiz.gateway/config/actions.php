<?php

use geoquiz\gateway\app\action\UserActionSignUp;
use Psr\Container\ContainerInterface;

return [
    UserActionSignUp::class => function (ContainerInterface $container) {
        return new UserActionSignUp(
            $container->get('uri.geoquizAuth'),
            $container->get('uri.geoquizApi')
        );
    }
];