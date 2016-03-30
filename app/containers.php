<?php

use RandomLib\Factory as RandomLib;

use Mailgun\Mailgun;

use FunnelCms\Debug\Debug;
use FunnelCms\User\User;
use FunnelCms\Mail\Mailer;
use FunnelCms\Helpers\Hash;
use FunnelCms\Validation\Validator;

/*
|--------------------------------------------------------------------------
| User instance
|--------------------------------------------------------------------------
|
| Create a new user instance.
| Callable throughout the application.
|
*/

$app->container->set('user', function() {
    return new User();
});

/*
|--------------------------------------------------------------------------
| Article instance
|--------------------------------------------------------------------------
|
| Create a new user instance.
| Callable throughout the application.
|
*/

$app->container->set('article', function() {
    return new \FunnelCms\Article\Article();
});

/*
|--------------------------------------------------------------------------
| Newsletter instance
|--------------------------------------------------------------------------
|
| Create a new user instance.
| Callable throughout the application.
|
*/

$app->container->set('newsletter', function() {
    return new \FunnelCms\Newsletter\Newsletter();
});

/*
|--------------------------------------------------------------------------
| Hash instance
|--------------------------------------------------------------------------
|
| Create a new hash instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('hash', function() use ($app) {
    return new Hash($app->config);
});

/*
|--------------------------------------------------------------------------
| Debug instance
|--------------------------------------------------------------------------
|
| Create a new db instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('debug', function() use($capsule) {
    return new Debug($capsule);
});

/*
|--------------------------------------------------------------------------
| Mailgun instance
|--------------------------------------------------------------------------
|
| Create a new Mailgun instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('mailgun', function() use($app) {
    return new Mailgun($app->config->get('mail.api_key'));
});

/*
|--------------------------------------------------------------------------
| Mailer instance
|--------------------------------------------------------------------------
|
| Create a new mailer instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('mail', function() use($app) {
    $mailer = new Mailgun($app->config->get('mail.api_key'));

    return new Mailer($app->config, $app->view, $app->mailgun);
});

/*
|--------------------------------------------------------------------------
| RandomLib instance
|--------------------------------------------------------------------------
|
| Create a new RandomLib instance, and set the strength of the generator.
| Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('randomlib', function() {
    $factory = new RandomLib();

    return $factory->getMediumStrengthGenerator();
});

/*
|--------------------------------------------------------------------------
| Validator instance
|--------------------------------------------------------------------------
|
| Create a new validator instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('validation', function() use($app) {
    return new Validator($app->user, $app->hash, $app->auth);
});