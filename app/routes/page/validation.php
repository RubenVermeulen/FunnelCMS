<?php

return [
    'name|' . $app->translator->get('Name') => [$name, 'required|max(50)'],
    'content|' . $app->translator->get('Content') => [$content, 'required|max(30000)'],
];