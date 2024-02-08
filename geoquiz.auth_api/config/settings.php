<?php

return [
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        // Database connection settings
        "db" => [
            "host" => "geoquiz-auth_db",
            "database" => "auth_db",
            "username" => "root",
            "password" => "PierreAndreGuenego",
            "driver" => "mysql",
        ],
        // JWT settings
        "jwt" => [
            'secret' => 'jwt_secret',
            'expires' => 3600,
            'issuer' => 'geoquiz.auth',
        ],
    ],
];