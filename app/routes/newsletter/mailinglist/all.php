<?php

use \FunnelCms\Helpers\PaginationMailgun;

function mailingListAllRoute($app, $page) {
    $pagination = new PaginationMailgun($app, $app->mail, $page);
    $pagination->execute();

    $app->render('newsletter/mailingList/all.twig', [
        'recipients' => $pagination->getResult(),
        'pages' => $pagination->getTotalPages(),
        'page' => $page,
    ]);
};

$app->get('/newsletters/mailing-list', $authenticated(), function($page = 1) use($app) {

    mailingListAllRoute($app, $page);

})->name('newsletter.mailingList.all');

$app->get('/newsletters/mailing-list/page/:page', $authenticated(), function($page = 1) use($app) {

    mailingListAllRoute($app, $page);

})->name('newsletter.mailingList.all.page');