<?php

$app->get('/files/edit/:id', $authenticated, function($id) use ($app) {

    $file = $app->file->find($id);

    if ( ! $file)
        $app->notFound();

    $app->render('file/edit.twig', [
        'id' => $id,
        'file' => $file,
    ]);

})->name('file.edit');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/files/edit/:id', $authenticated, function($id) use ($app) {

    $file = $app->file->find($id);

    if ( ! $file)
        $app->notFound();

    $request = $app->request;

    $name = $request->post('name');

    $v = $app->validation;

    $validationRules = [
        'name|' . $app->translator->get('Name') => [$name, 'required|max(255)'],
    ];

    $v->validate($validationRules);

    if ($v->passes()) {
        $file->update([
            'name_human' => $name,
        ]);

        $app->flash('global', 'Het bestand "' . $file->name_human . '" is gewijzigd.');
        $app->redirect($app->urlFor('file.all'));
    }

    $app->render('file/edit.twig', [
        'id' => $id,
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('file.edit.post');