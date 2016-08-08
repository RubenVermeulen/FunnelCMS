<?php

$app->get('/pages', $authenticated(), function() use($app) {

    $items = $app->page
        ->oldest('priority')
        ->get();

    $app->render('page/all.twig', [
        'items' => $items,
    ]);

})->name('page.all');