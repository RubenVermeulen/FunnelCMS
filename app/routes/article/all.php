<?php

use \FunnelCms\Helpers\Pagination;

function articlesAllRoute($app, $page) {
    $articles = $app->article
        ->latest('created_at')
        ->with(['author' => function($q) {
            return $q->withTrashed();
        }]);

    $pagination = new Pagination($app, $articles, $page);
    $pagination->execute();

    $app->render('article/all.twig', [
        'articles' => $pagination->getResult(),
        'pages' => $pagination->getTotalPages(),
        'page' => $page,
    ]);
};

$app->get('/articles', $authenticated(), function($page = 1) use($app) {

    articlesAllRoute($app, $page);

})->name('article.all');

$app->get('/articles/page/:page', $authenticated(), function($page = 1) use($app) {

    articlesAllRoute($app, $page);

})->name('article.all.page');