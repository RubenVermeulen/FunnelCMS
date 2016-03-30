<?php

$app->delete('/newsletters/mailing-list/:address', $authenticated(), function($address) use($app) {

    try {
        $app->mail->deleteRecipient($address);

        $app->flash('global', 'De ontvanger "' . $address . '" is verwijderd.');
    }
    catch (Exception $e) {
        $app->flash('error', $e->getMessage());
    }

    $app->redirect($app->urlFor('newsletter.mailingList.all'));

})->name('newsletter.mailingList.delete');