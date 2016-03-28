<?php

$app->get('/articles/edit/:id', $authenticated, function($id) use($app) {

    $article = $app->article->find($id);

    if ( ! $article)
        $app->notFound();

    $app->render('article/edit.twig', [
        'id' => $id,
        'article' => $article,
    ]);

})->name('article.edit');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/articles/edit/:id', $authenticated, function($id) use($app) {

    $article = $app->article->find($id);

    if ( ! $article)
        $app->notFound();

    $request = $app->request;

    $subject = $request->post('subject');
    $summary = $request->post('$summary');
    $content = $request->post('content');
    $date = $request->post('date');
    $time = $request->post('time');

    $v = $app->validation;

    $validationRules = include (__DIR__ . '/validation.php');

    $v->validate($validationRules);

    if ($v->passes()) {
        $article->update([
            'subject' => $subject,
            'summary' => $summary,
            'content' => $content,
            'published_at' => \Carbon\Carbon::createFromTimestamp(strtotime($date . ' '.  $time)),
        ]);

        $app->flash('global', 'Het artikel "' . $subject . '" is gewijzigd.');
        $app->redirect($app->urlFor('article.all'));
    }

    /*
     * Validation failed.
     */
    $app->render('article/edit.twig', [
        'id' => $id,
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('article.edit.post');