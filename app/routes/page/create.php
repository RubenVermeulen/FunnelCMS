<?php

$app->get('/pages/create', $authenticated, function() use ($app) {

    $app->render('page/create.twig');

})->name('page.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/pages/create', $authenticated, function() use ($app) {

    $request = $app->request;

    $name = $request->post('name');
    $content = $request->post('content');
    $isVisible = $request->post('is_visible');

    $v = $app->validation;

    $validationRules = include (__DIR__ . '/validation.php');

    $v->validate($validationRules);

    if ($v->passes()) {
        $slug = str_replace (" ", "-", strtolower($name));
        $slug = preg_replace('/[^a-zA-Z0-9-]/', '', $slug);

        // Check if slug exists
        if ($app->page->where('slug', $slug)->count() > 0) {
            $slug .= '-' . time();
        }

        $app->page->create([
            'name' => $name,
            'slug' => $slug,
            'content' => $content,
            'is_visible' => isset($isVisible),
        ]);

        $app->flash('global', 'De pagina "' . $name . '" is aangemaakt.');
        $app->redirect($app->urlFor('page.all'));
    }

    /*
     * Validation failed.
     */
    $app->render('page/create.twig', [
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('page.create.post');