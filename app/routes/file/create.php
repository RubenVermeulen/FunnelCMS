<?php

use FunnelCms\File\TmpFile;
use FunnelCms\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

$app->get('/files/create', $authenticated(), function() use($app) {

    $app->render('file/create.twig');

})->name('file.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/files/create', $authenticated(), function() use($app) {

    if(isset($_FILES['file']))
    {
        try
        {
            $request = Request::createFromGlobals();
            $file = $request->files->get('file');

            if( ! $file)
                throw new \Exception('Please choose a file');

            $uploadedFile = new UploadedFile($file, $app->storageProvider);

            $items = explode('/', $uploadedFile->store('files'));

            $name = array_pop($items);
            $path = empty($items) ? null : implode('/', $items);

            $app->file->create([
                'path' => $path,
                'name_system' => $name,
                'name_human' => strtolower($file->getClientOriginalname()),
                'size' => $file->getSize(),
            ]);

            $app->flash('global', 'Het bestand "' . $file->getClientOriginalname() . '" is geüpload.');
            $app->redirect($app->urlFor('file.all'));

        } catch (\Exception $e)
        {
            $app->flashNow('error', $e->getMessage());
        }

        $app->render('file/create.twig');
    }

})->name('file.create.post');