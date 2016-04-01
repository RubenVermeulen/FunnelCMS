<?php

use FunnelCms\Helpers\Pagination;

function filesAllRoute($app, $page) {

    $files = $app->file
        ->latest('created_at');

    $pagination = new Pagination($app, $files, $page);
    $pagination->execute();

    $app->render('file/all.twig', [
        'files' => $pagination->getResult(),
        'pages' => $pagination->getTotalPages(),
        'page' => $page,
    ]);
}

$app->get('/files', function($page = 1) use ($app) {

    filesAllRoute($app, $page);

})->name('file.all');

$app->get('/files/page/:page', function($page = 1) use ($app) {

    filesAllRoute($app, $page);

})->name('file.all.page');