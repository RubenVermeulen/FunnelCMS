<?php

$app->delete('/articles/:id', $admin(), function($id) use($app) {

    $article = $app->article->find($id);

    if ( ! $article)
        $app->notFound();

    $article->delete();

    $app->flash('global', 'Het artikel is verwijderd.');
    $app->redirect($app->urlFor('article.all'));

})->name('article.delete');