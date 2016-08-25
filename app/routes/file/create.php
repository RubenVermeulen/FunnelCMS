<?php

use FunnelCms\Exception\ExtensionNotAllowedException;
use FunnelCms\Exception\SizeLimitExceededException;
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
            $allowedExtensions = ['jpeg', 'png', 'gif', 'pdf'];
            $request = Request::createFromGlobals();
            $file = $request->files->get('file');

            if( ! $file)
                throw new \Exception('Please choose a file');

            if ($file->getError() != UPLOAD_ERR_OK)
                throw new \Exception($app->translator->get('CouldNotUploadFile'));

            if ( ! in_array(strtolower($file->guessClientExtension()), $allowedExtensions))
                throw new \Exception($app->translator->get('ExtensionNotAllowedFiles'));

            if ($file->getClientSize() > 500000)
                throw new \Exception(sprintf($app->translator->get('SizeLimitExceeded'), 500000 / 1000000));

            $uploadedFile = new UploadedFile($file, $app->storageProvider);

            $items = explode('/', $uploadedFile->store('files'));

            $name = array_pop($items);
            $path = empty($items) ? null : implode('/', $items);

            $app->file->create([
                'path' => $path,
                'name_system' => $name,
                'name_human' => strtolower(explode('.', $file->getClientOriginalname())[0]),
                'size' => $file->getSize(),
            ]);

            $app->flash('global', sprintf($app->translator->get('FileUploaded'), $file->getClientOriginalname()));
            $app->redirect($app->urlFor('file.all'));

        } catch (\Exception $e)
        {
            $app->flashNow('error', $e->getMessage());
        }

        $app->render('file/create.twig');
    }

})->name('file.create.post');