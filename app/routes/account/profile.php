<?php

$app->get('/account/profile', $authenticated, function() use($app) {

     $app->render('account/profile.twig');

})->name('account.profile');

/*
 * Handle requests.
 */

$app->post('/account/profile', $authenticated, function() use($app) {

    $request = $app->request;

    $email = $request->post('email');
    $firstName = $request->post('first_name');
    $lastName = $request->post('last_name');

    $v = $app->validation;

    $v->validate([
        'email|' . $app->translator->get('Email') => [$email, "required|email|uniqueEmail({$app->auth->email})"],
        'first_name|' . $app->translator->get('FirstName') => [$firstName, 'alpha|max(50)'],
        'last_name|' . $app->translator->get('LastName') => [$lastName, 'alpha|max(50)']
    ]);

    if ($v->passes()) {
        $app->auth->update([
            'email' => $email,
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);

        $app->flash('global', 'Je profiel is gewijzigd.');;
        $app->response->redirect($app->urlFor('account.profile'));
    }

    $app->render('account/profile.twig', [
        'errors' => $v->errors(),
        'request' => $request
    ]);

})->name('account.profile.post');