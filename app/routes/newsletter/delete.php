<?php

$app->delete('/newsletters/:id', $authenticated(), function($id) use($app) {

    $newsletter = $app->newsletter->find($id);

    if ( ! $newsletter)
        $app->notFound();

    $newsletter->delete();

    $app->flash('global', 'De nieuwsbrief "' . $newsletter->subject . '" is verwijderd.');
    $app->redirect($app->urlFor('newsletter.all'));

})->name('newsletter.delete');