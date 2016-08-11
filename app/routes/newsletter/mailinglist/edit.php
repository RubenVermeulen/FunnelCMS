<?php

$app->get('/newsletters/mailing-list/edit/:address', $authenticated, function($address) use ($app) {

    try {
        $recipient = $app->mail->getRecipient($address);
    }
    catch (Exception $e) {
        $app->notFound();
    }

    $app->render('newsletter/mailingList/edit.twig', [
        'recipient' => $recipient,
    ]);

})->name('newsletter.mailingList.edit');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/newsletters/mailing-list/edit/:address', $authenticated, function($address) use ($app) {

    try {
        $recipient = $app->mail->getRecipient($address);
    }
    catch (Exception $e) {
        $app->notFound();
    }

    $request = $app->request;

    $name = $request->post('name');
    $subscribe = $request->post('subscribe');

    $v = $app->validation;

    $v->validate([
        'name|' . $app->translator->get('Name') => [$name, 'max(150)'],
        'subscribe|"' . $app->translator->get('WantsNewsletter') . '"' => [$subscribe, 'min(0, number)|max(1, number)'],
    ]);

    if ($v->passes()) {
        try {
            $recipient->setName($name);
            $recipient->setSubscribed((bool) $subscribe);

            $app->mail->updateRecipient($recipient);

            $app->flash('global', 'De ontvanger "' . $recipient->getAddress() . '" is gewijzigd.');
            $app->redirect($app->urlFor('newsletter.mailingList.all'));
        }
        catch (\Exception $e) {
            $app->flashNow('error', $e->getMessage());
        }
    }

    $app->render('newsletter/mailingList/edit.twig', [
        'recipient' => $recipient,
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('newsletter.mailingList.edit.post');