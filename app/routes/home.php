<?php

$app->get('/', function() use ($app) {

    if ( ! $app->auth) {
        $app->redirect($app->urlFor('login'));
    }
    else {
        $app->render('home.twig');
    }

})->name('home');