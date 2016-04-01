<?php

$app->get('/files/search', $authenticated(), function() use($app) {

    $keyword = $app->request->get('keyword');

    if (empty($keyword) || strlen($keyword) == 0)
        $app->redirect($app->urlFor('file.all'));

    $files = $app->file
        ->latest('created_at')
        ->where('name_human', 'LIKE', "%{$keyword}%")
        ->orWhere('name_system', 'LIKE', "%{$keyword}%")
        ->get();

    $app->render('file/all.twig', [
        'files' => $files,
        'searchCount' => count($files),
        'keyword' => $keyword,
    ]);

})->name('file.search');