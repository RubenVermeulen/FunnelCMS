<?php

use  Mailgun\Connection\Exceptions\MissingRequiredParameters;
use FunnelCms\Mail\Recipient;
$app->get('/test', function() use ($app) {

    try {
        $recipient = new Recipient('ruben@fleeshuttle.be', 'Ruben Vermeulen', true);

        $app->mail->updateRecipient($recipient);
        echo 'Recipient updated';

    }
    catch (Exception $e) {
        echo $e->getMessage();
    }

})->name('test');