<?php

$app->delete('/pages/:id', $authenticated(), function($id) use($app) {

    $page = $app->page->find($id);

    if ( ! $page)
        $app->notFound();

    $page->delete();

    $app->flash('global', 'De pagina "' . $page->name . '" is verwijderd.');
    $app->redirect($app->urlFor('page.all'));

})->name('page.delete');