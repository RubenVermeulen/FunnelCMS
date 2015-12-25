<?php

$app->get('/articles/create', $authenticated, function() use ($app) {

    $app->render('article/create.twig', [
        'date' => date('Y-m-d'),
        'time' => date('H:i'),
    ]);

})->name('article.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/articles/create', $authenticated, function() use ($app) {

    $request = $app->request;

    $subject = $request->post('subject');
    $content = $request->post('content');
    $date = $request->post('date');
    $time = $request->post('time');

    $v = $app->validation;

    $v->validate([
        'subject|Onderwerp' => [$subject, 'required|max(150)'],
        'content|Bericht' => [$content, 'required|max(30000)'],
        'date|Datum' => [$date, 'required|date'],
        'time|Tijd' => [$time, 'required'],
    ]);

    if ($v->passes()) {
        $app->article->create([
            'subject' => $subject,
            'content' => $content,
            'published_at' => \Carbon\Carbon::createFromTimestamp(strtotime($date . ' '.  $time)),
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