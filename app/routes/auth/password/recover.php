<?php

$app->get('/recover-password', $guest(), function() use($app) {

    $app->render('auth/password/recover.twig');

})->name('auth.password.recover');

$app->post('/recover-password', $guest(), function() use($app) {

    $request = $app->request;

    $email = $request->post('email');

    $v = $app->validation;

    $v->validate([
        'email|E-mailadres' => [$email, 'required|email']
    ]);

    if ($v->passes()) {
        $user = $app->user->where('email', $email)->first();

        if ($user) {
            $identifier = $app->randomlib->generateString(128);

            $user->update([
                'recover_hash' => $app->hash->hash($identifier)
            ]);

            /*
             * Send an email.
             */
            $app->mail->send('email/auth/password/recover.twig', ['user' => $user, 'identifier' => $identifier], [
                'to' => $user->email,
                'subject' => 'Reset je wachtwoord.',
            ]);
        }

        $app->flash('global', 'Als we een gebruiker hebben met het gegeven e-mailadres zal je binnenkort instructies ontvangen om je wachtwoord te resetten.');
        $app->response->redirect($app->urlFor('login'));
    }

    $app->render('auth/password/recover.twig', [
        'errors' => $v->errors(),
        'request' => $request
    ]);

})->name('auth.password.recover.post');