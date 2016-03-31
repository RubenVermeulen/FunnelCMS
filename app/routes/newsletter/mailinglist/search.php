<?php

$app->get('/newsletters/mailing-list/search', $authenticated(), function() use($app) {

    $keyword = $app->request->get('keyword');

    if (empty($keyword) || strlen($keyword) == 0)
        $app->redirect($app->urlFor('newsletter.mailingList.all'));

    $recipients = $app->mail->searchRecipient($keyword);

    $app->render('newsletter/mailingList/all.twig', [
        'recipients' => $recipients,
        'searchCount' => count($recipients),
        'keyword' => $keyword,
    ]);

})->name('newsletter.mailingList.search');