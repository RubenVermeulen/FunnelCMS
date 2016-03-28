<?php

return [
    'subject|Onderwerp' => [$subject, 'required|max(150)'],
    'content|Bericht' => [$content, 'required|max(30000)'],
    'publish|"Wil je de nieuwsbrief verzenden?"' => [$publish, 'required|int'],
];