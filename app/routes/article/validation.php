<?php

return [
    'subject|Onderwerp' => [$subject, 'required|max(150)'],
    'summary|Korte beschrijving' => [$summary, 'required|max(150)'],
    'content|Bericht' => [$content, 'required|max(30000)'],
    'date|Datum' => [$date, 'required|date'],
    'time|Tijd' => [$time, 'required'],
];