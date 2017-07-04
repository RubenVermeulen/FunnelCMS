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
            $allowedExtensions = $app->config->get('storage.rules')['extensions'];
            $maxSize = $app->config->get('storage.rules')['maxSize'];
            $request = Request::createFromGlobals();
            $files = $request->files->get('file');

            foreach ($files as $file) {
                if( ! $file)
                    throw new \Exception('Please choose a file');

                if ($file->getError() != UPLOAD_ERR_OK)
                    throw new \Exception($app->translator->get('CouldNotUploadFile'));

                if ( ! in_array(strtolower($file->guessClientExtension()), $allowedExtensions))
                    throw new \Exception($app->translator->get('ExtensionNotAllowedFiles'));

                if ($file->getClientSize() > $maxSize)
                    throw new \Exception(sprintf($app->translator->get('SizeLimitExceeded'), $maxSize / 1000000));

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
            }

            $app->flash('global', 'uploaded');
            $app->redirect($app->urlFor('file.all'));

        } catch (\Exception $e)
        {
            $app->flashNow('error', $e->getMessage());
        }

        $app->render('file/create.twig');
    }

})->name('file.create.post');