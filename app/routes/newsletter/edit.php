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

    $validationRules = include(__DIR__ . '/validation.php');

    $v->validate($validationRules);

    if ($v->passes()) {
        $receivers = ($publish == 2) ? $app->mail->recipientsCount() : 0;

        $newsletter->update([
            'subject' => $subject,
            'content' => $content,
            'receivers' => $receivers,
            'published_at' => ($publish == 2) ? \Carbon\Carbon::now() : null,
        ]);

        if ($publish == 2) {
            $app->mail->sendNewsletter(
                $app->config->get('mail.template.newsletter'),
                ['content' => $content],
                [
                    'to' => $app->config->get('mail.list'),
                    'subject' => $subject,
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