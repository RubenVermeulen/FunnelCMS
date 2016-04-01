<?php

$app->delete('/files/:id', $authenticated(), function($id) use($app) {

    $file = $app->file->find($id);

    if ( ! $file)
        $app->notFound();

    $filePath = INC_ROOT . "/public/assets/files/{$file->name_system}";

    unlink($filePath);

    $file->delete();

    $app->flash('global', 'Het bestand "' . $file->name_human . '" is verwijderd.');
    $app->redirect($app->urlFor('file.all'));

})->name('file.delete');