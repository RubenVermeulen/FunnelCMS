<?php

use FunnelCms\Upload\LocalUploadProvider;
use RandomLib\Factory as RandomLib;

use Mailgun\Mailgun;

use FunnelCms\User\User;
use FunnelCms\Debug\Debug;
use FunnelCms\Mail\Mailer;
use FunnelCms\Helpers\Hash;
use FunnelCms\Mail\MailgunMailer;
use FunnelCms\Validation\Validator;

/*
|--------------------------------------------------------------------------
| Translator instance
|--------------------------------------------------------------------------
|
| Create a new translator instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('translator', function() use($app) {
    $map = json_decode(file_get_contents(INC_ROOT . '/app/translations/translations.' . $app->config->get('app.language') . '.json'), true);

    return new FunnelCms\Translator\Translator($map);
});

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
| Create a new newsletter instance.
| Callable throughout the application.
|
*/

$app->container->set('newsletter', function() {
    return new \FunnelCms\Newsletter\Newsletter();
});

/*
|--------------------------------------------------------------------------
| File instance
|--------------------------------------------------------------------------
|
| Create a new file instance.
| Callable throughout the application.
|
*/

$app->container->set('file', function() {
    return new \FunnelCms\File\File();
});

/*
|--------------------------------------------------------------------------
| Page instance
|--------------------------------------------------------------------------
|
| Create a new page instance.
| Callable throughout the application.
|
*/

$app->container->set('page', function() {
    return new \FunnelCms\Page\Page();
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
| Mailer instance
|--------------------------------------------------------------------------
|
| Create a new mailer instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('mail', function() use($app) {
    $mailer = new Mailgun($app->config->get('mail.private_api_key'));
    $mailerValidate = new Mailgun($app->config->get('mail.public_api_key'));

    return new MailgunMailer($app->config, $app->view, $mailer, $mailerValidate);
});

/*
|--------------------------------------------------------------------------
| Upload Provider instance
|--------------------------------------------------------------------------
|
| Create a new upload provider instance. Only created once.
| Callable throughout the application.
|
*/

$app->container->singleton('uploadProvider', function() use($app) {
    return new LocalUploadProvider($app->config);
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
    return new Validator($app->user, $app->hash, $app->auth, $app->translator);
});