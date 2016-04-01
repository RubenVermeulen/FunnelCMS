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

            $allowedExtensions = ['jpg', 'png', 'gif', 'pdf'];

            if ( ! in_array($extension, $allowedExtensions)) {
                $app->flashNow('error', 'Enkel bestanden met de extensie jpg, png, gif of pdf zijn toegestaan.');
            }
            else if ($size > 500000) {
                $app->flashNow('error', 'De bestandsgrootte mag niet groter zijn dan 0,5MB.');
            }
            else {
                // New details
                $key = md5(uniqid());
                $systemFileName = "{$key}.{$extension}";
                $newFilePath = INC_ROOT . "/public/assets/files/{$systemFileName}";

                // Move the file
                move_uploaded_file($tmpName, $newFilePath);

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