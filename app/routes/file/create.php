<?php

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

            if ( ! in_array($extension, $app->config->get('upload.rules.extensions'))) {
                $app->flashNow('error', 'Enkel bestanden met de extensie jpg, png, gif of pdf zijn toegestaan.');
            }
            else if ($size > $app->config->get('upload.rules.maxSize')) {
                $app->flashNow('error', "De bestandsgrootte mag niet groter zijn dan " . round($app->config->get('upload.rules.maxSize') / 1000000, 1) . "MB.");
            }
            else {

                // New details
                $key = md5(uniqid());
                $systemFileName = "{$key}.{$extension}";

                $tmp = new \FunnelCms\File\TmpFile();

                $tmp->setExtension($extension)
                    ->setNewName($systemFileName)
                    ->setSource($tmpName)
                    ->setContentType(mime_content_type($tmpName));
                
                $app->uploadProvider->upload($tmp);

                $app->file->create([
                    'name_system' => $systemFileName,
                    'name_human' => $humanFileName,
                    'size' => $size,
                ]);

                $app->flash('global', 'Het bestand "' . $name . '" is geüpload.');
                $app->redirect($app->urlFor('file.all'));
            }
        }
    }

    $app->render('file/create.twig');

})->name('file.create.post');