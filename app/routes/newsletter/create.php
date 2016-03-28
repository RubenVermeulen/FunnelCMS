<?php

use \TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

$app->get('/newsletters/create', $authenticated, function() use ($app) {

    $app->render('newsletter/create.twig');

})->name('newsletter.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/newsletters/create', $authenticated, function() use ($app) {

    $request = $app->request;

    $subject = $request->post('subject');
    $content = $request->post('content');
    $publish = $request->post('publish'); // 0: not chosen - 1: do not send - 2: send

    $v = $app->validation;

    $validationRules = include(__DIR__ . '/validation.php');

    $v->validate($validationRules);

    if ($v->passes()) {

        $receivers = ($publish == 2) ? $app->mailgun->get('lists/' . $app->config->get('mail.list'))->http_response_body->list->members_count : 0;

        $app->auth->newsletters()->create([
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

            $app->flash('global', 'De nieuwsbrief "' . $subject . '" is opgesteld en verzonden.');
        }
        else {
            $app->flash('global', 'De nieuwsbrief "' . $subject . '" is opgesteld.');
        }

        $app->redirect($app->urlFor('newsletter.all'));
    }

    /*
     * Validation failed.
     */
    $app->render('newsletter/create.twig', [
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('newsletter.create.post');