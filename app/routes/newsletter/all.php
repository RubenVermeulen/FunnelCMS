<?php

use \FunnelCms\Helpers\Pagination;

function newslettersAllRoute($app, $page) {
    $newsletters = $app->newsletter
        ->latest('created_at')
        ->with(['author' => function($q) {
            return $q->withTrashed();
        }]);

    $pagination = new Pagination($app, $newsletters, $page);
    $pagination->execute();

    $app->render('newsletter/all.twig', [
        'newsletters' => $pagination->getResult(),
        'pages' => $pagination->getTotalPages(),
        'page' => $page,
    ]);
};

$app->get('/newsletters', $authenticated(),function($page = 1) use($app) {

    newslettersAllRoute($app, $page);

})->name('newsletter.all');

$app->get('/newsletters(/page/:page)', $authenticated(),function($page = 1) use($app) {

    newslettersAllRoute($app, $page);

})->name('newsletter.all.page');