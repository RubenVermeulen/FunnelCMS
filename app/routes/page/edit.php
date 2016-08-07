<?php

$app->get('/pages/edit/:id', $authenticated, function($id) use($app) {

    $page = $app->page->find($id);

    if ( ! $page || $page->is_loced)
        $app->notFound();

    $app->render('page/edit.twig', [
        'id' => $id,
        'page' => $page,
    ]);

})->name('page.edit');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/pages/edit/:id', $authenticated, function($id) use($app) {

    $page = $app->page->find($id);

    if ( ! $page || $page->is_locked)
        $app->notFound();

    $request = $app->request;

    $name = $request->post('name');
    $content = $request->post('content');
    $isVisible = $request->post('is_visible');

    $v = $app->validation;

    $validationRules = include (__DIR__ . '/validation.php');

    $v->validate($validationRules);

    if ($v->passes()) {
        $modName = strtolower(trim($name));

        if ($modName != strtolower($page->name)) {
            $slug = str_replace (" ", "-", $modName);
            $slug = preg_replace('/[^a-zA-Z0-9-]/', '', $slug);

            // Check if slug exists
            if ($app->page->where('slug', $slug)->where('id', '!=', $page->id)->count() > 0) {
                $slug .= '-' . time();
            }
        }
        else {
            $slug = $page->slug;
        }

        $page->update([
            'name' => $name,
            'slug' => $slug,
            'content' => $content,
            'is_visible' => isset($isVisible),
        ]);

        $app->flash('global', 'De pagina "' . $name . '" is gewijzigd.');
        $app->redirect($app->urlFor('page.all'));
    }

    /*
     * Validation failed.
     */
    $app->render('page/edit.twig', [
        'id' => $id,
        'errors' => $v->errors(),
        'request' => $request,
    ]);

})->name('page.edit.post');