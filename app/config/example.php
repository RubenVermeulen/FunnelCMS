<?php

return [
    'app' => [
        'url' => 'http://www.example.local',
        'assetUrl' => 'http://static.example.local/assets',
        'hash' => [
            'algo' => PASSWORD_BCRYPT,
            'cost' => 10
        ]
    ],
    'db' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'name' => 'dbname',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => ''
    ],
    'auth' => [
        'session' => 'user_id',
        'remember' => 'user_r'
    ],
    // Mailgun
    'mail' => [
        'api_key' => '',
        'domain' => '',
        'list' => '',
        'from' => [
            'newsletter' => 'Example Newsletter <newsletter@example.local>',
            'noreply' => 'Example <noreply@example.local>'
        ],
    ],
    'twig' => [
        'debug' => true
    ],
    'csrf' => [
        'key' => 'csrf_token'
    ],
    'memcached' => [
        'host' => '127.0.0.1',
        'port' => '11211',
        'expiration' => 3600,
    ],
];