<?php

$app->get('/articles', $authenticated(),function() use($app) {

    $articles = $app->article->latest('created_at')->get();

    $app->render('article/all.twig', [
        'articles' => $articles
    ]);

})->name('article.all');