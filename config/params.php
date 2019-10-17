<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    // запросы у которых не проверяется сессия
    'openMethods' => [
        'api/auth',
        'api/get-doc'
    ],
];
