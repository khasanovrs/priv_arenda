<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    // запросы у которых не проверяется сессия
    'openMethods' => [
        'api/auth',

        'api/get-ur-client',
        'api/get-status',
        'api/get-source',
        'api/search-ur-client',
        'api/get-branch',
        'api/update-status-ur-client',
        'api/get-users',
        'api/get-roles',
        'api/get-rights'
    ],
];
