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
        $allowedExtensions = $app->config->get('storage.rules')['extensions'];
        $maxSize = $app->config->get('storage.rules')['maxSize'];
        $request = Request::createFromGlobals();
        $files = $request->files->get('file');
        $uploadedFiles = [];
        $failedFiles = [];

        foreach ($files as $file) {
            if( ! $file)
                throw new \Exception('Please choose a file');

            $fileName = $file->getClientOriginalname();
            if ($file->getError() != UPLOAD_ERR_OK) {
                $failedFiles[$fileName] = $app->translator->get('CouldNotUploadFile');
                continue;
            }

            if ( ! in_array(strtolower($file->guessClientExtension()), $allowedExtensions)) {
                $failedFiles[$fileName] = $app->translator->get('ExtensionNotAllowedFiles');
                continue;
            }

            if ($file->getClientSize() > $maxSize) {
                $failedFiles[$fileName] = sprintf($app->translator->get('SizeLimitExceeded'), $maxSize / 1000000);
                continue;
            }

            $uploadedFile = new UploadedFile($file, $app->storageProvider);

            $items = explode('/', $uploadedFile->store('files'));

            $name = array_pop($items);
            $path = empty($items) ? null : implode('/', $items);

            $app->file->create([
                'path' => $path,
                'name_system' => $name,
                'name_human' => strtolower(explode('.', $fileName)[0]),
                'size' => $file->getSize(),
            ]);

            $uploadedFiles[] = $fileName;
        }

        if (empty($failedFiles)) {
            $app->flash('global', sprintf($app->translator->get('FileUploaded'), implode(', ', $uploadedFiles)));
            $app->redirect($app->urlFor('file.all'));
        }
        else {
            $res = "";
            foreach ($failedFiles as $key => $value) {
                $res .= "$key: $value";
            }

            if (!empty($uploadedFiles)) {
                $app->flashNow('global', sprintf($app->translator->get('FileUploaded'), implode(', ', $uploadedFiles)));
            }

            $app->flashNow('error', $res);
        }

        $app->render('file/create.twig');
    }

})->name('file.create.post');