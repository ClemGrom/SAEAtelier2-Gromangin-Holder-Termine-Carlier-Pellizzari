<?php

use geoquiz\gateway\app\action\UserActionOther;
use geoquiz\gateway\app\action\UserActionSignUp;
use geoquiz\gateway\app\action\UserActionSigIn;
use Psr\Container\ContainerInterface;

return [
    UserActionSignUp::class => function (ContainerInterface $container) {
        return new UserActionSignUp(
            $container->get('uri.geoquizAuth'),
            $container->get('uri.geoquizApi')
        );
    },

    UserActionOther::class => function (ContainerInterface $container) {
        return new UserActionOther(
            $container->get('uri.geoquizAuth')
        );
    },

    UserActionSigIn::class => function (ContainerInterface $container) {
        return new UserActionSigIn(
            $container->get('uri.geoquizAuth'),
            $container->get('uri.geoquizApi')
        );
    },

];