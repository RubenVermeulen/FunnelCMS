<?php

use FunnelCms\File\TmpFile;

$app->get('/files/create', $authenticated(), function() use($app) {

    $app->render('file/create.twig');

})->name('file.create');

// -----------------------------------------------------
// -----------------------------------------------------

$app->post('/files/create', $authenticated(), function() use($app) {

    if(isset($_FILES['file'])) {

        $file = $_FILES['file'];

        if ($file['error'] != 0) {
            $app->flashNow('error', 'Je hebt nog geen bestand gekozen.');
        }
        else {
            // File details
            $name = $file['name'];
            $tmpName = $file['tmp_name'];

            $size = $file['size'];

            $extension = explode('.', $name);

            $humanFileName = strtolower($extension[0]);

            $extension = strtolower(end($extension));

            try
            {
                $tmpFile = new TmpFile($app->config->get('upload.rules'));

                $tmpFile
                    ->setExtension($extension)
                    ->setSize($size);

                $key = md5(uniqid());
                $systemFileName = "{$key}.{$extension}";

                $tmpFile
                    ->setName($systemFileName)
                    ->setSource($tmpName)
                    ->setContentType(mime_content_type($tmpName));

                $app->uploadProvider->upload($tmpFile);

                $app->file->create([
                    'name_system' => $systemFileName,
                    'name_human' => $humanFileName,
                    'size' => $size,
                ]);

                $app->flash('global', 'Het bestand "' . $name . '" is geüpload.');
                $app->redirect($app->urlFor('file.all'));
            }
            catch (\Exception $e) {
                $app->flashNow('error', $e->getMessage());
            }
        }
    }

    $app->render('file/create.twig');

})->name('file.create.post');