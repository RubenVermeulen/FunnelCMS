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
    $summary = $request->post('summary');
    $content = $request->post('content');
    $date = $request->post('date');
    $time = $request->post('time');

    $v = $app->validation;

    $validationRules = include (__DIR__ . '/validation.php');

    $v->validate($validationRules);

    if ($v->passes()) {
        $app->auth->articles()->create([
            'subject' => $subject,
            'summary' => $summary,
            'content' => $content,
            'published_at' => \Carbon\Carbon::createFromTimestamp(strtotime($date . ' '.  $time)),
        ]);

        $app->flash('global', 'Het artikel "' . $subject . '" is aangemaakt.');
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