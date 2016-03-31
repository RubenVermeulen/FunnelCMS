<?php

$app->get('/newsletter/search', $authenticated(), function() use($app) {

    $keyword = $app->request->get('keyword');

    if (empty($keyword) || strlen($keyword) == 0)
        $app->redirect($app->urlFor('newsletter.all'));

    $newsletters = $app->newsletter
        ->latest('created_at')
        ->with(['author' => function($q) {
            return $q->withTrashed();
        }])
        ->where('subject', 'LIKE', "%{$keyword}%")
        ->orWhere('content', 'LIKE', "%{$keyword}%")
        ->get();

    $app->render('newsletter/all.twig', [
        'newsletters' => $newsletters,
        'searchCount' => count($newsletters),
        'keyword' => $keyword,
    ]);

})->name('newsletter.search');