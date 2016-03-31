<?php

use \FunnelCms\Helpers\Pagination;

function usersAllRoute($app, $page) {
    $users = $app->user
        ->where('id', '!=', $app->auth->id)
        ->orderBy('email');

    $pagination = new Pagination($app, $users, $page);
    $pagination->execute();

    $app->render('user/all.twig', [
        'users' => $pagination->getResult(),
        'pages' => $pagination->getTotalPages(),
        'page' => $page,
    ]);
};

$app->get('/users', $admin(),function($page = 1) use($app) {

    usersAllRoute($app, $page);

})->name('user.all');

$app->get('/users/page/:page', $admin(),function($page = 1) use($app) {

    usersAllRoute($app, $page);

})->name('user.all.page');