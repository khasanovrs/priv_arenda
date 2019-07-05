<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    // запросы у которых не проверяется сессия
    'openMethods' => [
        'api/auth',
        'api/get-client',
        'api/get-status',
        'api/get-source',
        'api/search-client',
        'api/get-branch',
        'api/update-status-client',
        'api/get-roles',
        'api/get-rights',
        'api/get-discount',
        'api/get-users',
        'api/add-users',
        'api/get-client-fields',
        'api/add-client',
        'api/get-client-info',
        'api/change-client-fields',
        'api/update-client-info',
        'api/get-stock',
        'api/get-applications-status'
    ],
];
