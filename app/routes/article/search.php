<?php

$app->get('/article/search', $authenticated(), function() use($app) {

    $keyword = $app->request->get('keyword');

    if (empty($keyword) || strlen($keyword) == 0)
        $app->redirect($app->urlFor('article.all'));

    $articles = $app->article
        ->latest('created_at')
        ->with(['author' => function($q) {
            return $q->withTrashed();
        }])
        ->where('subject', 'LIKE', "%{$keyword}%")
        ->orWhere('summary', 'LIKE', "%{$keyword}%")
        ->orWhere('content', 'LIKE', "%{$keyword}%")
        ->get();

    $app->render('article/all.twig', [
        'articles' => $articles,
        'searchCount' => count($articles),
        'keyword' => $keyword,
    ]);

})->name('article.search');