<?php

$app->get('/articles', $authenticated(),function() use($app) {

    $articles = $app->article
        ->latest('created_at')
        ->with(['author' => function($q) {
            return $q->withTrashed();
        }])
        ->get();

    $app->render('article/all.twig', [
        'articles' => $articles
    ]);

})->name('article.all');