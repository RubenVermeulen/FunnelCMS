<?php

$app->get('/', function() use ($app) {

    if ( ! $app->auth) {
        $app->redirect($app->urlFor('login'));
    }
    else {
        $app->redirect($app->urlFor('page.all'));
    }

})->name('home');