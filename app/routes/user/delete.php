<?php

$app->delete('/users/:userId', $admin(), function($userId) use($app) {

    /*
     * Does the user exists.
     */
    try {
        $user = $app->user->findOrFail($userId);
    } catch (Exception $e) {
        $app->notFound();
    }

    if ($user->isActivated()) {
        $user->delete();
    }
    else{
        $user->forceDelete();
    }

    $app->flash('global', 'De gebruiker "' . $user->email . '" is verwijderd.');
    $app->redirect($app->urlFor('user.all'));

})->name('user.delete');