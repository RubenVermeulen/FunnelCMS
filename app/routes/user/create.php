<?php

$app->get('/users/create', $admin(), function() use($app) {

    $app->render('user/create.twig');

})->name('user.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/users/create', $admin(), function() use($app) {

    $request = $app->request;

    $email = $request->post('email');
    $permission = $request->post('permission');

    $v = $app->validation;

    $v->validate([
        'email|' . $app->translator->get('Email') => [$email, 'required|email|uniqueEmail|max(255)'],
        'permission|' . $app->translator->get('Rights') => [$permission, 'required|int'],
    ]);

    if ($v->passes()) {
        $identifier = $app->randomlib->generateString(128);

        $user = $app->user->create([
            'email' => $email,
            'active' => false,
            'active_hash' => $app->hash->hash($identifier)
        ]);

        $user->permissions()->create([
            'is_admin' => ($permission == 2 ? true : false),
        ]);

        /*
         * Send an email.
         */
        $app->mail->sendMessage('email/auth/registered.twig', ['user' => $user, 'identifier' => $identifier], [
            'from' => $app->config->get('mail.from.noreply'),
            'to' => $user->email,
            'subject' => 'Je account is aangemaakt.',
        ]);

        $app->flash('global', 'De gebruiker "' . $user->email . '" is aangemaakt. Hij/zij zal binnenkort een e-mail ontvangen met verdere intructies.');
        $app->response->redirect($app->urlFor('user.all'));
    }
    else {
        $user = $app->user->withTrashed()->where('email', $email)->first();

        if ($user) { // Undo soft delete and update permissions
            $user->restore();
            $user->permissions()->update([
                'is_admin' => ($permission == 2 ? true : false),
            ]);

            $app->flash('global', 'De gebruiker"' . $user->email . '" bestond al in ons systeem en is hersteld. Hij/zij kan inloggen met dezelfde gegevens.');
            $app->response->redirect($app->urlFor('user.all'));
        }
    }

    /*
     * Validation failed.
     */
    $app->render('user/create.twig', [
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('user.create.post');