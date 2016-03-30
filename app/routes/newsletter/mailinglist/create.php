<?php

$app->get('/newsletters/mailing-list/create', $authenticated, function() use ($app) {

    $app->render('newsletter/mailingList/create.twig');

})->name('newsletter.mailingList.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/newsletters/mailing-list/create', $authenticated, function() use ($app) {

    $request = $app->request;

    $email = $request->post('email');

    $v = $app->validation;

    $v->validate([
        'email|E-mailadres' => [$email, 'required|email'],
    ]);

    if ($v->passes()) {
        try {
            $app->mail->addRecipient($email);

            $app->flash('global', 'Het e-mailadres "' . $email . '" is toevoegd.');
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