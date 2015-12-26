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
        $article->update([
            'subject' => $subject,
            'content' => $content,
            'published_at' => \Carbon\Carbon::createFromTimestamp(strtotime($date . ' '.  $time)),
        ]);

        $app->flash('global', 'Het artikel is gewijzigd.');
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