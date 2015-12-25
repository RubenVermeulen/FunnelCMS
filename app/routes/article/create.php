<?php

$app->get('/articles/create', $authenticated, function() use ($app) {

    $app->render('article/create.twig');

})->name('article.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/articles/create', $authenticated, function() use ($app) {

    $request = $app->request;

    $subject = $request->post('subject');
    $content = $request->post('content');

    $v = $app->validation;

    $v->validate([
        'subject|Onderwerp' => [$subject, 'required|max(150)'],
        'content|Bericht' => [$content, 'required|max(30000)'],
    ]);

    if ($v->passes()) {
        $app->article->create([
            'subject' => $subject,
            'content' => $content,
        ]);

        $app->flash('global', 'Het artikel is aangemaakt.');
        $app->redirect($app->urlFor('article.all'));
    }

    /*
     * Validation failed.
     */
    $app->render('article/create.twig', [
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('article.create.post');