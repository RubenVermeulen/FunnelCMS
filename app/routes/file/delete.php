<?php

$app->delete('/files/:id', $authenticated(), function($id) use($app) {

    $file = $app->file->find($id);

    if ( ! $file)
        $app->notFound();

    $app->uploadProvider->delete($file->name_system);

    $file->delete();

    $app->flash('global', 'Het bestand "' . $file->name_human . '" is verwijderd.');
    $app->redirect($app->urlFor('file.all'));

})->name('file.delete');