<?php

$app->get('/newsletters/:id', $authenticated(), function($id) use($app) {

    $newsletter = $app->newsletter->find($id);

    if ( ! $newsletter)
        $app->notFound();

    $app->render('email/newsletter/newsletter-2016.twig', [
        'content' => $newsletter->content,
    ]);

})->name('newsletter.show');