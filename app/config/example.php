<?php

return [
    'app' => [
        'url' => 'http://www.example.local',
        'assetUrl' => 'http://static.example.local/assets',
        'hash' => [
            'algo' => PASSWORD_BCRYPT,
            'cost' => 10
        ],
        'pagination' => [
            'items' => 20, // Can not be higher then 100
        ],
        'language' => 'nl',
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
        'public_api_key' => '',
        'private_api_key' => '',
        'domain' => '',
        'list' => '',
        'from' => [
            'newsletter' => 'Example Newsletter <newsletter@example.local>',
            'noreply' => 'Example <noreply@example.local>'
        ],
        'template' => [
            'newsletter' => 'email/newsletter/newsletter-2016.twig',
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
    'upload' => [
        'galleryPath' => '', // start from the folder where app and public are located
        'rules' => [
            'maxSize' => 500000, // in byte
            'extensions' => ['jpg', 'png', 'gif', 'pdf'],
        ],
        'storage' => '',
        'local' => [
            'filePath' => '', // start from the folder where app and public are located
        ],
        'aws' => [
            'client' => [
                'version' => '',
                'region' => '',
                'credentials' => [
                    'key' => '',
                    'secret' => '',
                ],
            ],
            'bucket' => '',
        ]
    ]
];
