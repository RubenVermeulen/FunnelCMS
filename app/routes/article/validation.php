<?php

return [
    'subject|' . $app->translator->get('Subject') => [$subject, 'required|max(150)'],
    'summary|' . $app->translator->get('Summary') => [$summary, 'required|max(150)'],
    'content|' . $app->translator->get('Content') => [$content, 'required|max(30000)'],
    'date'. $app->translator->get('Date') => [$date, 'required|date'],
    'time|' . $app->translator->get('Time') => [$time, 'required'],
];