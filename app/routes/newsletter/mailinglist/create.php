<?php

use \FunnelCms\Mail\Recipient;

$app->get('/newsletters/mailing-list/create', $authenticated, function() use ($app) {

    $app->render('newsletter/mailingList/create.twig');

})->name('newsletter.mailingList.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/newsletters/mailing-list/create', $authenticated, function() use ($app) {

    $request = $app->request;

    $email = $request->post('email');
    $name = $request->post('name');

    $v = $app->validation;

    $v->validate([
        'email|E-mailadres' => [$email, 'required|email'],
        'name|Naam' => [$email, 'max(150)'],
    ]);

    if ($v->passes()) {
        try {
            $recipient = new Recipient($email, $name, true);

            $app->mail->addRecipient($recipient);

            $app->flash('global', 'De ontvanger "' . $recipient->getAddress() . '" is toegevoegd.');
            $app->redirect($app->urlFor('newsletter.mailingList.all'));
        }
        catch (\Exception $e) {
            $app->flashNow('error', $e->getMessage());
        }
    }

    /*
     * Validation failed.
     */
    $app->render('newsletter/mailingList/create.twig', [
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('newsletter.mailingList.create.post');