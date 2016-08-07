<?php

$app->get('/pages/search', $authenticated(), function() use($app) {

    $keyword = $app->request->get('keyword');

    if (empty($keyword) || strlen($keyword) == 0)
        $app->redirect($app->urlFor('page.all'));

    $items = $app->page
        ->latest('created_at')
        ->where('name', 'LIKE', "%{$keyword}%")
        ->orWhere('content', 'LIKE', "%{$keyword}%")
        ->get();

    $app->render('page/all.twig', [
        'items' => $items,
        'searchCount' => count($items),
        'keyword' => $keyword,
    ]);

})->name('page.search');