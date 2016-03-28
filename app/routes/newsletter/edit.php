<?php

$app->get('/newsletters/edit/:id', $authenticated, function($id) use ($app) {

    $newsletter = $app->newsletter->find($id);

    if ( ! $newsletter || $newsletter->published_at != null)
        $app->notFound();

    $app->render('newsletter/edit.twig', [
        'id' => $id,
        'newsletter' => $newsletter,
    ]);

})->name('newsletter.edit');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/newsletters/edit/:id', $authenticated, function($id) use ($app) {

    $newsletter = $app->newsletter->find($id);

    if ( ! $newsletter || $newsletter->published_at != null)
        $app->notFound();

    $request = $app->request;

    $subject = $request->post('subject');
    $content = $request->post('content');
    $publish = $request->post('publish'); // 0: not chosen - 1: do not send - 2: send

    $v = $app->validation;

    $validationRules = [
        'subject|Onderwerp' => [$subject, 'required|max(150)'],
        'content|Bericht' => [$content, 'required|max(30000)'],
        'publish|"Wil je de nieuwsbrief verzenden?"' => [$publish, 'required|int'],
    ];

    $v->validate($validationRules);

    if ($v->passes()) {
        $newsletter->update([
            'subject' => $subject,
            'content' => $content,
            'published_at' => ($publish == 2) ? \Carbon\Carbon::now() : null,
        ]);

        if ($publish == 2) {
            $app->mailgun->sendMessage($app->config->get('mail.domain'), [
                'from' => $app->config->get('mail.from.newsletter'),
                'to' => $app->config->get('mail.list'),
                'subject' => $subject,
                'html' => $content,
            ]);

            $app->flash('global', 'De nieuwsbrief "' . $subject . '" is gewijzigd en verzonden.');
        }
        else {
            $app->flash('global', 'De nieuwsbrief "' . $subject . '" is gewijzigd.');
        }

        $app->redirect($app->urlFor('newsletter.all'));
    }

    /*
     * Validation failed.
     */
    $app->render('newsletter/edit.twig', [
        'id' => $id,
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('newsletter.edit.post');