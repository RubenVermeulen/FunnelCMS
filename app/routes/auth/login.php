<?php

use Carbon\Carbon;

$app->get('/login', $guest(),  function() use ($app) {

    $app->render('auth/login.twig');

})->name('login');

/*
 * Handle requests.
 */

$app->post('/login', $guest(), function() use ($app) {

    $request = $app->request;

    $identifier = $request->post('identifier');
    $password = $request->post('password');
    $remember = $request->post('remember');

    $v = $app->validation;

    $v->validate([
        'identifier|E-mailadres' => [$identifier, 'required'],
        'password|Wachtwoord' => [$password, 'required']
    ]);

    if ($v->passes()) {
        $user = $app->user
            ->where('active', true)
            ->where(function($query) use ($identifier) {
                return $query->where('email', $identifier);
            })
            ->first();

        if ($user && $app->hash->passwordCheck($password, $user->password)) {
            $_SESSION[$app->config->get('auth.session')] = $user->id;

            if ($remember === 'on') {
                /*
                 * Generate an identifier until it's unique.
                 */
                do {
                    $rememberIdentifier = $app->randomlib->generateString(128);
                } while($user->rememberIdentifierExists($rememberIdentifier));

                $rememberToken = $app->randomlib->generateString(128);

                $user->updateRememberCredentials(
                    $rememberIdentifier,
                    $app->hash->hash($rememberToken)
                );

                $app->setCookie(
                    $app->config->get('auth.remember'),
                    "{$rememberIdentifier}___{$rememberToken}",
                    Carbon::parse('+6 month')->timestamp
                );
            }


            $app->flash('global', 'Je bent nu ingelogd.');
            $app->redirect($app->urlFor('home'));
        }
        else {
            $app->flash('error', 'Het was niet mogelijk om je in te loggen!');
            $app->redirect($app->urlFor('login'));
        }
    }

    $app->render('auth/login.twig', [
        'errors' => $v->errors(),
        'request' => $request
    ]);

})->name('login.post');