<?php

use  Mailgun\Connection\Exceptions\MissingRequiredParameters;

$app->get('/test', function() use ($app) {

    try {
        $app->mail->deleteRecipient('ruben.vermeulen@hotmail.com');
        echo 'Recipient deleted';
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

//    $mailgunValidate = new \Mailgun\Mailgun('pubkey-339e0910f422efccd347ca3b3d2a40d2');
//
    $validateAddress = 'rubeshuttle.be';
//
//    $result = $mailgunValidate->get('address/validate', ['address' => $validateAddress]);
//
//    echo $result->http_response_body->is_valid;

//    var_dump($app->mail->validateRecipient($validateAddress));

})->name('test');