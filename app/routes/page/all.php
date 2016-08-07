<?php

use \FunnelCms\Helpers\Pagination;

function pagesAllRoute($app, $page) {
    $items = $app->page
        ->oldest('priority');

    $pagination = new Pagination($app, $items, $page);
    $pagination->execute();

    $app->render('page/all.twig', [
        'items' => $pagination->getResult(),
        'pages' => $pagination->getTotalPages(),
        'page' => $page,
    ]);
};

$app->get('/pages', $authenticated(), function($page = 1) use($app) {

    pagesAllRoute($app, $page);

})->name('page.all');

$app->get('/pages/page/:page', $authenticated(), function($page = 1) use($app) {

    pagesAllRoute($app, $page);

})->name('page.all.page');