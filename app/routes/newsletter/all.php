<?php

$app->get('/newsletters', $authenticated(),function() use($app) {

    $newsletters = $app->newsletter
        ->latest('created_at')
        ->with(['author' => function($q) {
            return $q->withTrashed();
        }])
        ->get();

    $app->render('newsletter/all.twig', [
        'newsletters' => $newsletters
    ]);

})->name('newsletter.all');