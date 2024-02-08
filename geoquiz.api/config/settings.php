<?php

use Monolog\Level;

return [
    'logger.file' => __DIR__ . '/../../../logs/errors.log',
    'logger.level' => Level::Error,
    'connection.name.catalogue' => 'catalog',
    'uri.auth' => 'http://geoquiz-auth_service',
    'settings' => [
        "db" => [
            "host" => "geoquiz-api_db",
            "database" => "api_db",
            "username" => "root",
            "password" => "PierreAndreGuenego",
            "driver" => "mysql",
        ]
    ],
];