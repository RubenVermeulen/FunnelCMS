<?php

return [
    'subject|Onderwerp' . $app->translator->get('Subject') => [$subject, 'required|max(150)'],
    'content|Bericht' . $app->translator->get('Content') => [$content, 'required|max(30000)'],
    'publish|"' . $app->translator->get('DoYouWantToSendNewsletter') . '"' => [$publish, 'required|int'],
];